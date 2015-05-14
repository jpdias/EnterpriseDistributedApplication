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
    public class User
    {
        public BsonObjectId _id;
        [DataMember]
        public string Username { get; set; }
        [DataMember]
        public string Password { get; set; }

        public User(string user, string pass)
        {
            Username = user;
            Password = pass;
        }
        
    }
}
