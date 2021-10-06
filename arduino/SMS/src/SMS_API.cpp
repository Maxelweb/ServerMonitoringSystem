#include "SMS_API.h"

SMS_API::SMS_API(IPAddress ip, IPAddress gateway, IPAddress dns, IPAddress subnet, uint16_t port) {
    
    byte default_mac[] = {0xDE, 0xBE, 0xBE, 0xEF, 0xFE, 0xED};
    
    ip_addr = ip;
    gateway_addr = gateway;
    dns_addr = dns;
    subnet_addr = subnet;
    port = port;
    mac_addr = default_mac;
}


void SMS_API::startServer(){
    Ethernet.begin(mac_addr, ip_addr, dns_addr, gateway_addr, subnet_addr);
    server.begin();
    return;
}


void SMS_API::serve(){
    // listen for incoming clients
    EthernetClient client = server.available();
    if (client) {
        // Serial.println("new client");
        // an http request ends with a blank line
        boolean currentLineIsBlank = true;
        while (client.connected()) {
        if (client.available()) {
            char c = client.read();
            Serial.write(c);
            // if you've gotten to the end of the line (received a newline
            // character) and the line is blank, the http request has ended,
            // so you can send a reply
            if (c == '\n' && currentLineIsBlank) {
            // send a standard http response header
            client.println("HTTP/1.1 200 OK");
            client.println("Content-Type: text/html");
            client.println("Connection: close");  // the connection will be closed after completion of the response
            client.println();
            client.println("<!DOCTYPE HTML>");
            client.println("<html>");
            // output the value of each analog input pin
            client.println("hello world lmao");
            client.println("</html>");
            break;
            }
            if (c == '\n') {
            // you're starting a new line
            currentLineIsBlank = true;
            }
            else if (c != '\r') {
            // you've gotten a character on the current line
            currentLineIsBlank = false;
            }
        }
        }
        // give the web browser time to receive the data
        delay(1);
        // close the connection:
        client.stop();
        Serial.println("client disconnected");
    }
    return;
}