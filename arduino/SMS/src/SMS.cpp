#include "SMS.h"

SMS::SMS()
{
	DoorSonar = NewPing(SONARPIN_TRIG, SONARPIN_ECHO, SMAX_DISTANCE);
	THSensor = dht11();
	Working = true;
	Started = false;
}

void SMS::setInitialPinMode()
{
	Serial.begin(9600);

	pinMode(LEDPIN, OUTPUT);
	pinMode(BUZZPIN, OUTPUT);

	pinMode(THPIN, INPUT);
	pinMode(LIGHTPIN, INPUT);
}


bool SMS::isDoorOpen()
{
	return DoorSonar.ping_cm() == 0;
}

void SMS::updateTH()
{
	if(THSensor.read(THPIN) != 0)
		Working = false;
}

int SMS::getTemperature()
{
	return THSensor.temperature;
}

int SMS::getHumidity()
{
	return THSensor.humidity;
}

bool SMS::isLightUp()
{
	return analogRead(LIGHTPIN) > 60;
}

void SMS::LedWorking()
{
	if(Working)
		digitalWrite(LEDPIN, HIGH);
	else
	{
		digitalWrite(LEDPIN, HIGH);
		delay(50);
		digitalWrite(LEDPIN, LOW);
		delay(50);
	}
}

void SMS::Started()
{
	if(!Startup)
	{
		NewTone(BUZZPIN, 1000, 500);
		delay(1500);
		noNewTone(BUZZPIN);
		Startup = true;
	}
}
