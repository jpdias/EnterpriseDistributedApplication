using System;
using System.Collections.Generic;
using System.Diagnostics;
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
        [DataMember]
        public ObjectId _id;
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
            _id = new ObjectId(DateTime.Now, Process.GetCurrentProcess().SessionId, (short)Process.GetCurrentProcess().Id, 1); 
            Email = email;
            Name = name;
            Address = address;
            Password = password;
        }

        public Customer(string email)
        {
            Email = email;
        }
    }
}
