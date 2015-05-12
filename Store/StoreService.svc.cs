using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Net;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using EnterpriseDistributedApplication;
using MongoDB;
using MongoDB.Bson;
using MongoDB.Driver;

namespace Store
{
    // NOTE: You can use the "Rename" command on the "Refactor" menu to change the class name "StoreService" in code, svc and config file together.
    // NOTE: In order to launch WCF Test Client for testing this service, please select StoreService.svc or StoreService.svc.cs at the Solution Explorer and start debugging.
    public class StoreService : IStoreService
    {
        public List<Book> GetBooks(string id)
        {

            MongoConnectionHandler dbConnection = new MongoConnectionHandler("store", "admin", "eda_store");
            var collection = dbConnection.dbClient.GetCollection<Book>("books");

            var task = collection.Find(book => book.Title != "").ToListAsync();

            task.Wait();
            var results = task.Result;

            return results;

        }

        public HttpStatusCode AddBook(Book book)
        {
            MongoConnectionHandler dbConnection = new MongoConnectionHandler("store", "admin", "eda_store");
            var collection = dbConnection.dbClient.GetCollection<Book>("books");

            var task = collection.InsertOneAsync(book);

            task.Wait();
            var results = task;

            return (HttpStatusCode) task.Status;
        }


    }
}
