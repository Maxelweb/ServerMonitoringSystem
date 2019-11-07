#include "SMS.h"

SMS::SMS()
: DoorSonar(new UltraSonicDistanceSensor(SONARPIN_TRIG, SONARPIN_ECHO)),
THSensor(new dht11()), Startup(false), DoorDistance(-1), LightPower(-1),
currentInterval(millis()+2000), EnableAlarm(true)
{ }

void SMS::setInitialPinMode()
{
	Serial.begin(9600);
	Serial.setTimeout(600);

	pinMode(LEDPIN, OUTPUT);
	pinMode(BUZZPIN, OUTPUT);

	pinMode(THPIN, INPUT);
	pinMode(LIGHTPIN, INPUT);
}

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
	// More resistence == Lower value
	return LightPower < 160;
}


void SMS::Started()
{
	if(!Startup)
	{
		NewTone(BUZZPIN, 1000, 500);
		delay(500);
		Startup = true;
	}
}

void SMS::LedAlerts()
{
	/* Red Led Cases:
		- off == Ok
		- blink == Low / High humidity
		- on == High temperature
	*/

	if(getTemperature() > 30)
	{
		digitalWrite(LEDPIN, HIGH);
	}
	else if(getHumidity() > 60)
	{
		digitalWrite(LEDPIN, LOW);
		delay(20);
		digitalWrite(LEDPIN, HIGH);
	}
	else
	{
		digitalWrite(LEDPIN, LOW);
	}
}

void SMS::LedConnected(bool conn)
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

void SMS::Alarms()
{
	/*	Alarms:
			- Temperature to high in server room
			- forgot light up in server room (disabled)
	*/

	if(EnableAlarm)
	{
		if(getTemperature() > 30)
		{
			NewTone(BUZZPIN, 800, 100);
		}
		/*else if(isLightUp() && !isDoorOpen())
		{
			NewTone(BUZZPIN, 1200, 100);
		}*/
	}
}