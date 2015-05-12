using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MongoDB.Driver;

namespace EnterpriseDistributedApplication
{
 
    public class MongoConnectionHandler
    {
        public IMongoDatabase dbClient { get; private set; }

        public MongoConnectionHandler(string username, string password, string dbName)
        {
        
            string connectionString = String.Format("mongodb://{0}:{1}@ds034348.mongolab.com:34348/{2}",username,password,dbName);
            

            var mongoClient = new MongoClient(connectionString);

            string databaseName = dbName;

            dbClient = mongoClient.GetDatabase(databaseName);

        }
    }
}
