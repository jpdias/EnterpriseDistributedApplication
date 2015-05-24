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
    [DataContract(Name = "Order")]
    [KnownType(typeof (Book))]
    [KnownType(typeof (int))]
    [KnownType(typeof (Customer))]
    [KnownType(typeof (State))]
    public class Order
    {
        public ObjectId _id;

        [DataMember(Name = "Book")]
        public Book Book { get; set; }

        [DataMember(Name = "Quantity")]
        public int Quantity { get; set; }

        [DataMember(Name = "Customer")]
        public Customer Customer { get; set; }

        [DataMember(Name = "State")]
        public State State { get; set; }

        public Order(Book book, int quantity, Customer customer)
        {

            _id = new ObjectId(DateTime.Now, Process.GetCurrentProcess().SessionId,
                (short) Process.GetCurrentProcess().Id, 1);
            Book = book;
            Quantity = quantity;
            Customer = customer;
            State = new State(State.state.Waiting, DateTime.Now);
        }
    }

    [DataContract(Name = "State")]
    public class State
    {
        public State(state currentState, DateTime dateTime)
        {
            this.CurrentState = currentState;
            this.dateTime = dateTime;
        }

        public enum state
        {
            Waiting,
            Dispatched,
            WaitingDispatch
        }

        [DataMember(Name = "CurrentState")]
        public state CurrentState { get; set; }

        [DataMember(Name = "dateTime")]
        public DateTime dateTime { get; set; }
    }
}
