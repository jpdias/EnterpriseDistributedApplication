using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace EnterpriseDistributedApplication
{
    class Customer
    {
        private string Email { get; set; }
        private string Name { get; set; }
        private string Address { get; set; }

        public Customer(string email, string name, string address)
        {
            this.Email = email;
            this.Name = name;
            this.Address = address;
        }
    }
}
