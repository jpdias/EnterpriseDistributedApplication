using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Web;
using EnterpriseDistributedApplication;
using MongoDB.Driver;
using Store.WarehouseService;

namespace Store
{
    
    public class OrdersOps
    {
        private MongoConnectionHandler dbConnection;
        private WarehouseServiceClient warehouseService;
        public static event EventHandler ThrowEvent = delegate { };

        public OrdersOps()
        {
            dbConnection = new MongoConnectionHandler("store", "admin", "eda_store");
            warehouseService = new WarehouseServiceClient();
        }

        public OrdersOps(string stuff)
        {
            dbConnection = new MongoConnectionHandler("store", "admin", "eda_store");
        }

        public static void UpdateGUI()
        {
            if (ThrowEvent != null)
            {
                ThrowEvent(null, EventArgs.Empty);
                ThrowEvent.Invoke(null, null);
            }
        }

        public Order ProcessNewOrder(Order order)
        {
            var collectionBook = dbConnection.dbClient.GetCollection<Book>("books");
            var collectionOrders = dbConnection.dbClient.GetCollection<Order>("orders");
            

            var task = collectionBook.Find(b => b.Title == order.Book.Title && b.Editor == order.Book.Editor).FirstOrDefaultAsync();

            task.Wait();
            var results = task.Result;

            if (results != null && results.Stock > 0)
            {
                var filter = Builders<Book>.Filter.Eq(b => b.Title, order.Book.Title);
                var update1 = Builders<Book>.Update.Inc(b => b.Stock, -order.Quantity);
                var updateTask = collectionBook.UpdateOneAsync(filter, update1);
                updateTask.Wait();

                order.State = new State(State.state.Dispatched, DateTime.Now);
                order.State.dateTime = DateTime.Now;

                var insertOrder = collectionOrders.InsertOneAsync(order);
                insertOrder.Wait();
                var insertResult = insertOrder;
                if (insertResult.IsCompleted)
                {
                    UpdateGUI();
                    return order;
                }
            }
            else
            {
                order.State = new State(State.state.Waiting, DateTime.Now);
                order.State.dateTime = DateTime.Now;

                warehouseService.ReportToWarehouse(order);

                var insertOrder = collectionOrders.InsertOneAsync(order);
                insertOrder.Wait();
                var insertResult = insertOrder;

                if (insertResult.IsCompleted)
                {
                    UpdateGUI();
                    return order;
                }

            }

            UpdateGUI();
            return order;
        }

        public List<Order> GetPendingOrders()
        {
            var collectionOrders = dbConnection.dbClient.GetCollection<Order>("orders");
            var task = collectionOrders.Find(ord => ord.State.CurrentState == State.state.WaitingDispatch).ToListAsync();
            task.Wait();

            return task.Result;
        }

        public Order ProcessNewPackage(Order order)
        {
            
            var collectionBook = dbConnection.dbClient.GetCollection<Book>("books");
            var collectionOrders = dbConnection.dbClient.GetCollection<Order>("orders");

            var task = collectionOrders.Find(ord => ord.Book._id == order.Book._id).ToListAsync();
            task.Wait();

            foreach (var ord in task.Result)
            {
                if (ord.State.CurrentState == State.state.Waiting && order.Book.Stock > 0)
                {
                    var filterOrders = Builders<Order>.Filter.Eq(o => o._id, ord._id);
                    var updateOrders = Builders<Order>.Update.Set(o => o.State.CurrentState, State.state.WaitingDispatch);
                    collectionOrders.UpdateOneAsync(filterOrders, updateOrders);
                    order.Book.Stock -= ord.Quantity;
                    Email.SendEmail(order.Customer.Email, "Book", "State:" + order.State.CurrentState + "\n" + "Book: " + order.Book.Title);
                }
            }

            var filter = Builders<Book>.Filter.Eq(b => b._id, order.Book._id);
            var update2 = Builders<Book>.Update.Inc(b => b.Stock, order.Book.Stock);
            var updateTask = collectionBook.UpdateOneAsync(filter, update2);
            updateTask.Wait();

            UpdateGUI();
            return order;
        }
    }
}