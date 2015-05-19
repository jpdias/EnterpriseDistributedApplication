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
        public OrdersOps()
        {
            dbConnection = new MongoConnectionHandler("store", "admin", "eda_store");
            warehouseService = new WarehouseServiceClient();
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
                var update = Builders<Book>.Update.Inc(b => b.Stock, -order.Quantity);
                var updateTask = collectionBook.UpdateOneAsync(filter, update);
                updateTask.Wait();

                order.State = new State(State.state.Dispatched, DateTime.Now);
                order.State.dateTime = DateTime.Now;

                var insertOrder = collectionOrders.InsertOneAsync(order);
                insertOrder.Wait();
                var insertResult = insertOrder;
                if (insertResult.IsCompleted)
                {
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
                    return order;
                }
                
            }
            return order;
        }

    }
}