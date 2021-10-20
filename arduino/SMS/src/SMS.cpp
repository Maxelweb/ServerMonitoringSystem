#include "SMS.h"

SMS::SMS()
: DoorSonar(new UltraSonicDistanceSensor(SONARPIN_TRIG, SONARPIN_ECHO)),
THSensor(new dht11()), Startup(false), DoorDistance(-1), LightPower(-1),
currentInterval(millis()+2000), EnableAlarm(true), IntrusionDetection(true)
{ }

void SMS::setInitialPinMode()
{
	Serial.begin(9600);
	Serial.setTimeout(600);

	pinMode(LEDPIN, OUTPUT);
	pinMode(BUZZPIN, OUTPUT);

	pinMode(THPIN, INPUT);
	pinMode(LIGHTPIN, INPUT);

	// disable SD card if one in the slot
  	pinMode(4,OUTPUT);
  	digitalWrite(4,HIGH);
}

// Update Readings
// ----------------------------------

void SMS::updateSensors()
{
	unsigned long interval = millis();
	if(interval - currentInterval >= UPDATE_INTERVAL)
	{
		THSensor->read(THPIN);		
		currentInterval = interval;
	}
	
	LightPower = analogRead(LIGHTPIN);
	DoorDistance = DoorSonar->measureDistanceCm();
}

// Current Sensors Readings
// ----------------------------------

int SMS::getTemperature() const
{
	return THSensor->temperature;
}

int SMS::getHumidity() const
{
	return THSensor->humidity;
}

bool SMS::isDoorOpen()
{
	return DoorDistance > 18; // cm
}

bool SMS::isLightUp()
{
	// pin X = Ground
	// pin Y = Resistor 10k from a 5v + Analog read
	// More resistence == Lower value
	return LightPower < 160;
}

// Led and Audio alerts
// ----------------------------------

void SMS::initStartup()
{
	if(!Startup)
	{
		NewTone(BUZZPIN, 1000, 500);
		digitalWrite(LEDPIN, HIGH);
		delay(1000);
		digitalWrite(LEDPIN, LOW);
		Startup = true;
	}
}

void SMS::checkLedAlerts()
{
	/* Yellow Led Cases:
		- off == Ok
		- blink == Low / High humidity
		- on == High temperature
	*/

	if(getTemperature() > 28)
	{
		digitalWrite(LEDPIN, HIGH);
	}
	else if(getHumidity() > 50)
	{
		digitalWrite(LEDPIN, LOW);
		delay(100);
		digitalWrite(LEDPIN, HIGH);
	}
	else
	{
		digitalWrite(LEDPIN, LOW);
	}
}

void SMS::checkLedConnection(bool conn)
{
	if(!conn)
	{
		analogWrite(LEDCONN, 150);
	}
	else
	{
		analogWrite(LEDCONN, 0);
	}
}

void SMS::checkAlarms()
{
	/*	Alarms:
			- Temperature to high in server room
	*/

	if(EnableAlarm)
	{
		if(getTemperature() > 30)
		{
			NewTone(BUZZPIN, 800, 100);
		}
	}
}

int SMS::emitTestSound() 
{
	NewTone(BUZZPIN,294,125);
	delay(125);
	NewTone(BUZZPIN,294,125);
	delay(125);
	NewTone(BUZZPIN,587,250);
	delay(250);
	NewTone(BUZZPIN,440,250);
	delay(375);
	NewTone(BUZZPIN,415,125);
	delay(250);
	NewTone(BUZZPIN,392,250);
	delay(250);
	NewTone(BUZZPIN,349,250);
	delay(250);
	NewTone(BUZZPIN,294,125);
	delay(125);
	NewTone(BUZZPIN,349,125);
	delay(125);
	NewTone(BUZZPIN,392,125);
	delay(125);
	return 1;
}

int SMS::checkIntrusionDetection() {
	if(IntrusionDetection && isLightUp() && isDoorOpen()){
		// NewTone(BUZZPIN, 294, 100);
		// digitalWrite(LEDPIN, HIGH);
		// delay(20);
		// digitalWrite(LEDPIN, LOW);
		return 1;
	}
	return 0;
}