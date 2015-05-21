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

            var task = collection.Find(u => u.Username == user.Username).FirstOrDefaultAsync();

            task.Wait();
            var results = task.Result;
            if (results.Password == user.Password)
            {
                return true;
            }
            return false;
        }

        public bool AuthenticateCustomer(Customer customer)
        {
            var collection = dbConnection.dbClient.GetCollection<Customer>("customers");

            var task = collection.Find(c => c.Email == customer.Email).FirstOrDefaultAsync();

            task.Wait();
            var results = task.Result;
            if (results.Email == customer.Email && results.Password == customer.Password)
            {
                return true;
            }
            return false;
        }

        public bool CreateCustomer(Customer customer)
        {
            var collection = dbConnection.dbClient.GetCollection<Customer>("customers");

            var task = collection.InsertOneAsync(customer);

            task.Wait();
            var results = task;

            if(results.IsCompleted)
                return true;
            
            return false;
        }
    }
}