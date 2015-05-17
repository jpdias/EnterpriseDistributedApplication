using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Mail;
using System.Web;
using Mandrill;
using Mandrill.Models;
using Mandrill.Requests.Messages;

namespace Store
{
    public static class Email
    {
        public static async void SendEmail(string destination, string subject, string content)
        {
            MandrillApi api = new MandrillApi("Kj-1SGPKFICoSgUIo9OEqw");

            var mandrillRecipients = new List<EmailAddress>();
            mandrillRecipients.Add(new EmailAddress(destination));
            // add recipents to the mandrillRecipientsList
            var email = new EmailMessage
            {
                To = mandrillRecipients,
                FromEmail = "book@eda.com",
                FromName = "Book Store Support",
                Subject = subject,
                Text = content,
                RawMessage = content
            };

            await api.SendMessage(new SendMessageRequest(email));

        }
    }
}