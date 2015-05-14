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
    public class Order
    {
        public BsonObjectId _id;
        [DataMember]
        public Book Book { get; set; }
        [DataMember]
        public int Quantity { get; set; }
        [DataMember]
        public Customer Customer { get; set; }
        [DataMember]
        public State State { get; set; }

        public Order(Book book, int quantity, Customer customer, State state)
        {
            Book = book;
            Quantity = quantity;
            Customer = customer;
            State = state;
        }
    }
    [DataContract]
    public class State
    {
        public State(state currrentState, DateTime? dateTime)
        {
            this.CurrrentState = currrentState;
            this.dateTime = dateTime;
        }

        public enum state
        {
            Waiting, Dispatched, WaitingDispatch
        }

        [DataMember]
        public state CurrrentState { get; set; }
        [DataMember]
        public DateTime? dateTime { get; set; }
    }
}
