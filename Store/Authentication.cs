using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Web;
using EnterpriseDistributedApplication;
using MongoDB.Driver;

namespace Store
{
    public class Authentication
    {
        private MongoConnectionHandler dbConnection;

        public Authentication()
        {
            dbConnection = new MongoConnectionHandler("store", "admin", "eda_store");
        }

        public bool AuthenticateUser(User user)
        {
            var collection = dbConnection.dbClient.GetCollection<User>("users");

            Debug.WriteLine(user.Username + "  " + user.Password);
            var task = collection.Find(u => u.Username == user.Username).FirstOrDefaultAsync();

            task.Wait();
            var results = task.Result;
            if (results.Password == user.Password)
            {
                return true;
            }
            return false;
        }

        public bool AuthenticateCustomer(Customer costumer)
        {
            var collection = dbConnection.dbClient.GetCollection<Customer>("customers");

            var task = collection.Find(u => u.Email == costumer.Email).FirstOrDefaultAsync();

            task.Wait();
            var results = task.Result;
            if (results.Password == costumer.Password)
            {
                return true;
            }
            return false;
        }

        public bool CreateCustomer(Customer costumer)
        {
            var collection = dbConnection.dbClient.GetCollection<Customer>("customers");

            var task = collection.InsertOneAsync(costumer);

            task.Wait();
            var results = task;

            if(results.IsCompleted)
                return true;
            
            return false;
        }
    }
}