#include "SMS.h"

SMS::SMS()
: DoorSonar(new UltraSonicDistanceSensor(SONARPIN_TRIG, SONARPIN_ECHO)),
THSensor(new dht11()), Working(false), Startup(false), DoorDistance(-1), LightPower(-1),
EnableAlarm(true)
{ }

void SMS::setInitialPinMode()
{
	Serial.begin(9600);
	Serial.setTimeout(600);

	pinMode(LEDPIN, OUTPUT);
	pinMode(BUZZPIN, OUTPUT);
	// pinMode(LEDCONN, OUTPUT);

	pinMode(THPIN, INPUT);
	pinMode(LIGHTPIN, INPUT);
}

void SMS::updateSensors()
{
	LightPower = analogRead(LIGHTPIN);
	DoorDistance = DoorSonar->measureDistanceCm();

	if(THSensor->read(THPIN) != 0)
		Working = false;
	else if(!Working)
			Working = true;
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
	return DoorDistance > 20; // cm
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
		noNewTone(BUZZPIN);
		Startup = true;
	}
}

void SMS::LedWorking()
{
	/* Red Led Cases:
		- off == Working
		- on == Sensors not working
		- blink == Temperature or Humidity too high	
	*/

	if(Working 	&& getTemperature() < 30 
				&& getHumidity() < 80 
				&& getHumidity() > 30)
	{
		digitalWrite(LEDPIN, LOW);
	}
	else if(!Working)
	{
		digitalWrite(LEDPIN, HIGH);
	}
	else
	{
		digitalWrite(LEDPIN, LOW);
		delay(20);
		digitalWrite(LEDPIN, HIGH);
		delay(20);
	}
}

void SMS::LedConnected(bool conn)
{
	if(!conn)
	{
		for(unsigned short i = 0; i<250; i+=10)
		{
			analogWrite(LEDCONN, i);
			delay(20);
		}

		for(unsigned short i = 250; i>0; i-=10)
		{	
			analogWrite(LEDCONN, i);
			delay(20);
		}
	}
}

void SMS::Alarms()
{
	/*	Alarms:
			- Temperature to high in server room
			- forgotten light up in server room
	*/

	if(EnableAlarm)
	{
		if(getTemperature() > 30)
		{
			NewTone(BUZZPIN, 800, 350);
		}
		else if(isLightUp() && !isDoorOpen())
		{
			NewTone(BUZZPIN, 1200, 200);
		}
	}
}