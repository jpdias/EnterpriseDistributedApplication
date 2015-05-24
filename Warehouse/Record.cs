using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using EnterpriseDistributedApplication;

namespace Warehouse
{
    class Record
    {
        private MongoConnectionHandler dbConnection;

        public Record()
        {
            dbConnection = new MongoConnectionHandler("warehouse", "admin", "eda_warehouse");
        }

        public OrderBooks ProcessPackage(OrderBooks order)
        {
            var collectionOrders = dbConnection.dbClient.GetCollection<OrderBooks>("orders");

            var task = collectionOrders.InsertOneAsync(order);

            return order;
        }
    }
}
