using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MongoDB.Bson;

namespace EnterpriseDistributedApplication
{
    public class Customer
    {
        public BsonObjectId _id;
        public string Email { get; set; }
        public string Name { get; set; }
        public string Address { get; set; }

        public Customer(string email, string name, string address)
        {
            this.Email = email;
            this.Name = name;
            this.Address = address;
        }
    }
}
