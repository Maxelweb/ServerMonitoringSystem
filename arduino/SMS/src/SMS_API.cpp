#include "SMS_API.h"

SMS_API::SMS_API(byte * mac, IPAddress ip, uint8_t port)
 : mac_addr(mac),ip_addr(ip),port(port) 
{ }


void SMS_API::initializeServer() {
    this->mac_addr = {
        0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED
    };
    EthernetServer server(this->port);
    this->server = server;
    return;
}
void SMS_API::startServer(){
    Ethernet.begin(this->mac_addr, this->port);
    this->server.begin();
    // Serial.print("Server is at ");
    // Serial.println(Ethernet.localIP());
    return;
}

// TODO: fix this and checkout noduino https://github.com/fcaldas/Noduino

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
            client.println("Refresh: 5");  // refresh the page automatically every 5 sec
            client.println();
            client.println("<!DOCTYPE HTML>");
            client.println("<html>");
            // output the value of each analog input pin
            for (int analogChannel = 0; analogChannel < 6; analogChannel++) {
                int sensorReading = analogRead(analogChannel);
                client.print("analog input ");
                client.print(analogChannel);
                client.print(" is ");
                client.print(sensorReading);
                client.println("<br />");
            }
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