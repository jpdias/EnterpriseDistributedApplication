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
    public class Order
    {
        public ObjectId _id;
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

            _id = new ObjectId(DateTime.Now, Process.GetCurrentProcess().SessionId, (short)Process.GetCurrentProcess().Id, 1); 
            Book = book;
            Quantity = quantity;
            Customer = customer;
            State = state;
        }
    }
    [DataContract]
    public class State
    {
        public State(state currentState, DateTime? dateTime)
        {
            this.CurrentState = currentState;
            this.dateTime = dateTime;
        }

        public enum state
        {
            Waiting, Dispatched, WaitingDispatch
        }

        [DataMember]
        public state CurrentState { get; set; }
        [DataMember]
        public DateTime? dateTime { get; set; }
    }
}
