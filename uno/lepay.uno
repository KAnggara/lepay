#include <WiFi.h>
#include <Arduino.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include "config.h"

int ledState = LOW; // ledState used to set the LED
bool relayState = 0;
unsigned long getMilis = 0;

const char *ssid = WIFI_SSID;
const char *password = WIFI_PASS;
const int ledPin = LED_BUILTIN; // the number of the LED pin
const long interval = 1;        // interval at which to get data in second
const String serverGet = "http://api.wahyuda.my.id:3000/hardware/";

void setup()
{
  Serial.begin(115200);
  pinMode(ledPin, OUTPUT);
  wifiConnect();
}

void wifiConnect()
{
  Serial.print(F("\n\nConnecting to "));
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.print(".");
  }

  Serial.println(F("\nWiFi connected"));
  Serial.print(F("IP address: "));
  Serial.println(WiFi.localIP());
}

bool getData()
{
  String res;
  HTTPClient http;
  http.begin(serverGet + hardwareId);
  int httpCode = http.GET();
  Serial.print("HTTP Response code: ");
  Serial.println(httpCode);

  if (httpCode > 0)
  {
    res = http.getString();
    StaticJsonDocument<1024> json;
    deserializeJson(json, res);
    Serial.println(res);
    bool relay = json["state"];
    return relay;
  }
  return 0;
}

void loop()
{
  long milis = millis() / 1000;
  if (milis - getMilis >= interval)
  {
    Serial.println("=======================");
    getMilis = milis;
    relayState = getData();
    // check relay state
    if (relayState == true)
    {
      digitalWrite(ledPin, HIGH);
    }
    else
    {
      digitalWrite(ledPin, LOW);
    }
  }
}
