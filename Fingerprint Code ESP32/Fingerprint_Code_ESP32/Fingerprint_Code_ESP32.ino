
#include <WiFi.h>                   // For ESP32 WiFi functionality
#include <HTTPClient.h>             // For HTTP requests
#include <Simpletimer.h>            // For timer functions (https://github.com/jfturcot/SimpleTimer)
// OLED Display
#include <SPI.h>
#include <Wire.h>
#include <Adafruit_GFX.h>           // Adafruit GFX Library (https://github.com/adafruit/Adafruit-GFX-Library)
#include <Adafruit_SSD1306.h>       // Adafruit OLED SSD1306 Library (https://github.com/adafruit/Adafruit_SSD1306)
// Fingerprint Sensor
#include <Adafruit_Fingerprint.h>   // Fingerprint Sensor Library (https://github.com/adafruit/Adafruit-Fingerprint-Sensor-Library)

/* ----------------------------------------------------------------------------- 
  - Project: Biometric Attendance System Using IOT
  - Author:  Team Fingering IOT
  - Date:    12/09/2024
----------------------------------------------------------------------------- */

#define Finger_Rx 0 //D3
#define Finger_Tx 2 //D4
#define SCREEN_WIDTH 128 
#define SCREEN_HEIGHT 64 
#define OLED_RESET 0 

Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);
HardwareSerial mySerial(1);  // 1 refers to UART1, you can change it to 2 if needed
mySerial.begin(9600, SERIAL_8N1, Finger_Rx, Finger_Tx);  // Initialize with correct baudrate and pin numbers

const char *ssid = "SKY GUEST";
const char *password = "Qwert12345.*";
const char* device_token = "Device Token"; // Obtain this from your server or IoT platform

String postData;
String link = "https://wheat-wolf-261457.hostingersite.com/getdata.php";

int FingerID = 0;
uint8_t id;

void setup() {
  Serial.begin(115200);

  if (!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) {
    Serial.println(F("SSD1306 allocation failed"));
    while (true);
  }

  display.display();
  delay(2000);
  display.clearDisplay();

  connectToWiFi();

  finger.begin(57600);
  Serial.println("\n\nAdafruit Fingerprint Sensor Test");

  if (finger.verifyPassword()) {
    Serial.println("Fingerprint sensor found!");
    display.clearDisplay();
    display.drawBitmap(34, 0, FinPr_valid_bits, FinPr_valid_width, FinPr_valid_height, WHITE);
    display.display();
  } else {
    Serial.println("Fingerprint sensor not found!");
    display.clearDisplay();
    display.drawBitmap(32, 0, FinPr_failed_bits, FinPr_failed_width, FinPr_failed_height, WHITE);
    display.display();
    while (true);
  }

  finger.getTemplateCount();
  Serial.print("Sensor contains "); 
  Serial.print(finger.templateCount); 
  Serial.println(" templates");
  Serial.println("Waiting for valid finger...");
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    connectToWiFi();
  }

  FingerID = getFingerprintID();
  delay(50);
  DisplayFingerprintID();
  ChecktoAddID();
  ChecktoDeleteID();
}

void connectToWiFi() {
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi!");
}

void DisplayFingerprintID() {
  if (FingerID > 0) {
    display.clearDisplay();
    display.drawBitmap(34, 0, FinPr_valid_bits, FinPr_valid_width, FinPr_valid_height, WHITE);
    display.display();
    SendFingerprintID(FingerID);
  } else if (FingerID == 0) {
    display.clearDisplay();
    display.drawBitmap(32, 0, FinPr_start_bits, FinPr_start_width, FinPr_start_height, WHITE);
    display.display();
  } else if (FingerID == -1) {
    display.clearDisplay();
    display.drawBitmap(34, 0, FinPr_invalid_bits, FinPr_invalid_width, FinPr_invalid_height, WHITE);
    display.display();
  } else if (FingerID == -2) {
    display.clearDisplay();
    display.drawBitmap(32, 0, FinPr_failed_bits, FinPr_failed_width, FinPr_failed_height, WHITE);
    display.display();
  }
}

void SendFingerprintID(int finger) {
  WiFiClient client;
  HTTPClient http;

  postData = "FingerID=" + String(finger); 
  http.begin(client, link);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(postData);
  String payload = http.getString();

  Serial.println(httpCode);
  Serial.println(payload);
  Serial.println(postData);
  Serial.println(finger);

  if (payload.startsWith("login")) {
    String user_name = payload.substring(5);
    display.clearDisplay();
    display.setTextSize(2);
    display.setTextColor(WHITE);
    display.setCursor(15, 0);
    display.print("Welcome");
    display.setCursor(0, 20);
    display.print(user_name);
    display.display();
  } else if (payload.startsWith("logout")) {
    String user_name = payload.substring(6);
    display.clearDisplay();
    display.setTextSize(2);
    display.setTextColor(WHITE);
    display.setCursor(10, 0);
    display.print("Good Bye");
    display.setCursor(0, 20);
    display.print(user_name);
    display.display();
  }

  delay(1000);
  postData = "";
  http.end();
}

// The rest of the helper functions for fingerprint operations go here
