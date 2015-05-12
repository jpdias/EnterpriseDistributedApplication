using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.Text;
using System.Threading.Tasks;
using MongoDB.Bson;

namespace EnterpriseDistributedApplication
{
    [DataContract]
    public class Customer
    {
        public BsonObjectId _id;
        [DataMember]
        public string Email { get; set; }
        [DataMember]
        public string Name { get; set; }
        [DataMember]
        public string Address { get; set; }
        [DataMember]
        public string Password { get; set; }
       

        public Customer(string email, string name, string address, string password)
        {
            Email = email;
            Name = name;
            Address = address;
            Password = password;
        }
    }
}
