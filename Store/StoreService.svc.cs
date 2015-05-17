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
using Store.WarehouseService;

namespace Store
{
    public class StoreService : IStoreService
    {
        public List<Book> GetBooks()
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
         
            return (HttpStatusCode) task.Status;
        }

        public List<Customer> GetCustomers()
        {

            MongoConnectionHandler dbConnection = new MongoConnectionHandler("store", "admin", "eda_store");
            var collection = dbConnection.dbClient.GetCollection<Customer>("customers");

            var task = collection.Find(customer => customer.Email != "").ToListAsync();

            task.Wait();
            var results = task.Result;

            return results;

        }

        public Customer GetCustomer(string email)
        {

            MongoConnectionHandler dbConnection = new MongoConnectionHandler("store", "admin", "eda_store");
            var collection = dbConnection.dbClient.GetCollection<Customer>("customers");

            var task = collection.Find(customer => customer.Email == email).ToListAsync();

            task.Wait();
            var results = task.Result;

            return results[0];

        }

        public List<Order> GetCustomerOrders(string email)
        {

            MongoConnectionHandler dbConnection = new MongoConnectionHandler("store", "admin", "eda_store");
            var collection = dbConnection.dbClient.GetCollection<Order>("orders");

            var task = collection.Find(order => order.Quantity != 0).ToListAsync();
            
            task.Wait();
            var results = task.Result;
            
            return results;

        }

        public Order NewOrder()
        {
            OrdersOps operation = new OrdersOps();
             
            Book booktest = new Book("Harry Potter",20.0,"PortoEditora");
            Customer customertest = new Customer("joao@mail.com");
            Order test = new Order(booktest, 9,customertest,new State(State.state.Waiting, null));
            Order result = operation.ProcessNewOrder(test);

            return result;
        }

        public HttpStatusCode PackageEnter(Order order)
        {
            Debug.WriteLine(order.Book.Title);
            Email.SendEmail(order.Customer.Email, "Book","State:" + order.State.CurrentState +"\n"+"Book: "+order.Book.Title);
            return HttpStatusCode.OK;
        }
    }
}
