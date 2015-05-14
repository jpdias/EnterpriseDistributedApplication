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

            }
            else
            {
                warehouseService.ReportToWarehouse(order.Book);
            }
            return order;
        }

    }
}