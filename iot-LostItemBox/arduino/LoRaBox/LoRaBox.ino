#include <SoftwareSerial.h>
#include "SNIPE.h"

#define PING  1
#define PONG  2

#define CODE  PING    /* Please define PING or PONG */

#define TXpin 11
#define RXpin 10
#define ATSerial Serial

//16byte hex key
String lora_app_key = "11 22 33 44 55 66 77 88 99 aa bb cc dd ee ff 00";  

const int trigPin = 2;
const int echoPin = 4;

const int trigPinL = 13;
const int echoPinL = 12;

SoftwareSerial DebugSerial(RXpin,TXpin);
SNIPE SNIPE(ATSerial);

void setup() {
  ATSerial.begin(115200);

  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  pinMode(trigPinL, OUTPUT);
  pinMode(echoPinL, INPUT);

  // put your setup code here, to run once:
  while(ATSerial.read()>= 0) {}
  while(!ATSerial);

  DebugSerial.begin(115200);

  /* SNIPE LoRa Initialization */
  if (!SNIPE.lora_init()) {
    DebugSerial.println("SNIPE LoRa Initialization Fail!");
    while (1);
  }

  /* SNIPE LoRa Set Appkey */
  if (!SNIPE.lora_setAppKey(lora_app_key)) {
    DebugSerial.println("SNIPE LoRa app key value has not been changed");
  }
  
  /* SNIPE LoRa Set Frequency */
  if (!SNIPE.lora_setFreq(LORA_CH_1)) {
    DebugSerial.println("SNIPE LoRa Frequency value has not been changed");
  }

  /* SNIPE LoRa Set Spreading Factor */
  if (!SNIPE.lora_setSf(LORA_SF_7)) {
    DebugSerial.println("SNIPE LoRa Sf value has not been changed");
  }

  /* SNIPE LoRa Set Rx Timeout 
   * If you select LORA_SF_12, 
   * RX Timout use a value greater than 5000  
  */
  if (!SNIPE.lora_setRxtout(5000)) {
    DebugSerial.println("SNIPE LoRa Rx Timout value has not been changed");
  }  
    
  DebugSerial.println("SNIPE LoRa PingPong Test");
}

void loop() {
  
    digitalWrite(trigPin, HIGH);
    delayMicroseconds(10);
    digitalWrite(trigPin, LOW);

    long distanceR = pulseIn(echoPin, HIGH) / 58;

    digitalWrite(trigPinL, HIGH);
    delayMicroseconds(10);
    digitalWrite(trigPinL, LOW);

    long distanceL = pulseIn(echoPinL, HIGH) / 58;
  
#if CODE == PING
        char a[50];
        sprintf(a,"BOX L: %ld R: %ld",distanceL,distanceR);
        String full=a;
        if (SNIPE.lora_send(full))
        {
          DebugSerial.println("send success");
          
          String ver = SNIPE.lora_recv();
          DebugSerial.println(full);
          DebugSerial.print(distanceR);
          DebugSerial.println( "CM");
          DebugSerial.print(distanceL);
          DebugSerial.println( "CM");
          
          delay(100);
          

          if (ver == "PONG")
          {
            DebugSerial.println("recv success");
            DebugSerial.println(SNIPE.lora_getRssi());
            DebugSerial.println(SNIPE.lora_getSnr());            
          }
          else
          {
            DebugSerial.println("recv fail");
            delay(500);
          }
        }
       delay(1000);
       
#elif CODE == PONG
        String ver = SNIPE.lora_recv();
        delay(300);

        DebugSerial.println(ver);
        
        if (ver == "PING" )
        {
          DebugSerial.println("recv success");
          DebugSerial.println(SNIPE.lora_getRssi());
          DebugSerial.println(SNIPE.lora_getSnr());

          if(SNIPE.lora_send("PONG"))
          {
            DebugSerial.println("send success");
            DebugSerial.print(distanceR);
            DebugSerial.println( "CM");
            DebugSerial.print(distanceL);
            DebugSerial.println( "CM");
          }
          else
          {
            DebugSerial.println("send fail");
            delay(500);
          }
        }
       delay(1000);
#endif
}
