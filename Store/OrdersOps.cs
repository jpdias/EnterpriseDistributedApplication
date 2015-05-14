using System;
using System.Collections.Generic;
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
            var collection = dbConnection.dbClient.GetCollection<Book>("books");

            var task = collection.Find(b => b.Title == order.Book.Title && b.Editor == order.Book.Editor).FirstOrDefaultAsync();

            task.Wait();
            var results = task.Result;

            if (results != null && results.Stock > 0)
            {
                var filter = Builders<Book>.Filter.Eq(b => b.Title, order.Book.Title);
                var update = Builders<Book>.Update.Inc(b => b.Stock, -1);
                var updateTask = collection.UpdateOneAsync(filter, update);
                updateTask.Wait();
            }
            else
            {
                warehouseService.ReportToWarehouse(order.Book);
            }
            return order;
        }

    }
}