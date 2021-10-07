#include "SMS_API.h"

SMS_API::SMS_API(SMS * sm, IPAddress ip, IPAddress gateway, IPAddress dns, IPAddress subnet, uint16_t port) {
    
    byte default_mac[] = {0x45, 0x45, 0x45, 0x45, 0x45, 0x45};
    sms = sm;
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


void SMS_API::getHomepage(EthernetClient& client) {
    client.println("HTTP/1.1 200 OK");
    client.println("Content-Type: text/html");
    client.println("Connection: close");  // the connection will be closed after completion of the response
    client.println();
    client.println("<!DOCTYPE HTML>");
    client.println("<head>");
    client.println("<title>Server Monitoring System - Arduino Web</title>");
    client.println("<style>body{font-family: arial, sans-serif; font-size: 110%; background-color: #333; color: #CCC;} a {color: #008184} a:hover {color: #FFF} img {max-width: 100%; display:block; margin: 20px 0; border-radius:8px;} </style>");
    client.println("</head><html><body>");
    client.println("<img src='https://debug.ovh/images/yes-jim.gif' width='240'>");
    client.println("<h1>Server Monitoring System <small style='color: #FFF'>by Maxelweb</small></h1>");
    client.println("<a href='https://github.com/Maxelweb/ServerMonitoringSystem'>Checkout the project repository on Github</a> <br><br>");
    client.println("Welcome! It looks like everything is working&trade; so far..");
    client.println("<br> From here you can call the APIs available to read the values from the sensors.");
    client.println("<br> <h2>Arduino configuration</h2>");
    client.print("<ul><li><b>IP Address:</b> ");
    client.print(ip_addr);
    client.print("</li><li><b>DNS:</b> ");
    client.print(dns_addr);
    client.print("</li><li><b>Gateway:</b> ");
    client.print(gateway_addr);
    client.print("</li><li><b>Subnet mask:</b> ");
    client.print(subnet_addr);
    client.print("</li><li><b>Uptime:</b> ");
    client.print((millis()/1000/60/60/24));
    client.print(" days, ");
    client.print((millis()/1000/60/60));
    client.print(" hours, ");
    client.print((millis()/1000/60));
    client.print(" minutes</li></ul>");
    client.println("</body></html>");
    return;
}

void SMS_API::getAllSensors(EthernetClient& client) {

    client.println("HTTP/1.1 200 OK");
    client.println("Content-Type: application/json");
    client.println("Connection: close"); 
    client.println("");
    client.print("{");
    client.print("\"temperature\":\"");
    client.print(sms->getTemperature());
    client.print("\",");
    client.print("\"humidity\":\"");
    client.print(sms->getHumidity());
    client.print("\",");
    client.print("\"door_open\":\""); 
    client.print((sms->isDoorOpen() ? "1" : "0")); 
    client.print("\",");
    client.print("\"lights_up\":\""); 
    client.print((sms->isLightUp() ? "1" : "0")); 
    client.print("\"");
    client.print("}");
    return;
}

void SMS_API::get(EthernetClient& client, String name, int value) {
    return SMS_API::get(client, name, String(value));
}

void SMS_API::get(EthernetClient& client, String name, String value) {

    client.println("HTTP/1.1 200 OK");
    client.println("Content-Type: application/json");
    client.println("Connection: close"); 
    client.println("");
    client.print("{");
    client.print("\"" + name + "\":\"");
    client.print(value);
    client.print("\"");
    client.print("}");
    return; 
}


void SMS_API::serve(){
    // listen for incoming clients
    EthernetClient client = server.available();
    String urlRequest;
    if (client) {
        Serial.println("new client");
        // an http request ends with a blank line
        while (client.connected()) {
            if (client.available()) {
                
                char c = client.read();
                                
                // Getting the entire string, at most 100 characters
                //if (urlRequest.length() < 100) {
                    urlRequest += c; 
                // } 
                
                // Http request has ended (\n char), send a reply
                if (c == '\n') {
                    
                    if(urlRequest.indexOf("sensors/temperature") > -1)
                        this->get(client, "temperature", sms->getTemperature());
                    else if(urlRequest.indexOf("sensors/humidity") > -1)
                        this->get(client, "humidity", sms->getHumidity());
                    else if(urlRequest.indexOf("sensors/door_open") > -1)
                        this->get(client, "door_open", sms->isDoorOpen());
                    else if(urlRequest.indexOf("sensors/lights_up") > -1)
                        this->get(client, "lights_up", sms->isLightUp());
                    else if(urlRequest.indexOf("sensors") > -1)
                        this->getAllSensors(client);
                    else if(urlRequest.indexOf("sound/test") > -1)
                        this->get(client, "sound_test", sms->emitTestSound());
                    else
                        this->getHomepage(client);

                    delay(1);
                    client.stop();
                    Serial.println("goodbye client");
                    urlRequest = "";
                }
            }
        }
    }
    return;
}