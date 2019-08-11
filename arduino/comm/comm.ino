
// Test iniziali


int ledPin = 13;

void setup() 
{
    pinMode(ledPin, OUTPUT);
    Serial.begin(9600);
}


void loop() 
{
 
    digitalWrite(ledPin, HIGH);
    delay(1000);
  
    for(byte n = 0; n < 150; n++)
    {
        Serial.write(n);
        delay(50);
    }

    digitalWrite(ledPin, LOW);
    delay(1000);

}
