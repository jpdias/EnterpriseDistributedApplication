using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Runtime.Serialization;
using System.Text;
using System.Threading.Tasks;
using MongoDB.Bson;
using MongoDB.Bson.Serialization.Attributes;

namespace EnterpriseDistributedApplication
{
    [DataContract(Name = "Customer")]
    public class Customer
    {
        [DataMember(Name = "_id")]
        [BsonId]
        [BsonRepresentation(BsonType.ObjectId)]
        public string _id;
        [DataMember(Name = "Email")]
        public string Email { get; set; }
        [DataMember(Name = "Name")]
        public string Name { get; set; }
        [DataMember(Name = "Address")]
        public string Address { get; set; }
        [DataMember(Name = "Password")]
        public string Password { get; set; }
       

        public Customer(string email, string name, string address, string password)
        {
            _id = new ObjectId(DateTime.Now, Process.GetCurrentProcess().SessionId, (short)Process.GetCurrentProcess().Id, 1).ToJson(); 
            Email = email;
            Name = name;
            Address = address;
            Password = password;
        }
        public Customer(string id, string email, string name, string address, string password)
        {
            _id = id;
            Email = email;
            Name = name;
            Address = address;
        }
    }
}
