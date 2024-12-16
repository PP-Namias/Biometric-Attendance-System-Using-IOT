#include <WiFi.h>
#include <HTTPClient.h>
#include <Adafruit_Fingerprint.h>
#include <Base64.h> // Include Base64 library for encoding
#include <ArduinoJson.h>

#define RX_PIN 16
#define TX_PIN 17

WiFiServer server(80);
HardwareSerial mySerial(2);
Adafruit_Fingerprint finger(&mySerial);

// Wi-Fi credentials
const char* ssid = "ZTE_2.4G_GEa3KH";
const char* password = "NikolaiRivamonte@123";

// Server URL
const char* serverURL = "http://192.168.1.12/BiometricAttendance/insert_fingerprint.php";

String name, gender, department;
int fingerprintId;

void setup() {
  Serial.begin(115200);
  mySerial.begin(57600, SERIAL_8N1, RX_PIN, TX_PIN);

  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");

  //start the wifi server
  server.begin();
  // Initialize fingerprint sensor
  finger.begin(57600);
  if (finger.verifyPassword()) {
    Serial.println("Fingerprint sensor initialized!");
  } else {
    Serial.println("Failed to initialize the fingerprint sensor.");
    while (1) delay(1); // Stay in this loop if initialization fails
  }
}

uint8_t getFingerprintEnroll() {
  int p = -1;
  Serial.println("Waiting for valid finger to enroll...");
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    if (p == FINGERPRINT_OK) {
      Serial.println("Image taken");
    }
  }

  // Convert the image to template
  p = finger.image2Tz(1);
  if (p != FINGERPRINT_OK) {
    Serial.println("Error converting image to template.");
    return p;
  }

  Serial.println("Place the same finger again for confirmation...");
  delay(2000); // Wait for user to remove the finger

  p = -1;
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    if (p == FINGERPRINT_OK) {
      Serial.println("Image taken");
    }
  }

  p = finger.image2Tz(2);
  if (p != FINGERPRINT_OK) {
    Serial.println("Error converting image to template.");
    return p;
  }

  Serial.println("Creating model...");
  p = finger.createModel();
  if (p != FINGERPRINT_OK) {
    Serial.println("Error creating model.");
    return p;
  }

  // Store the model
  p = finger.storeModel(fingerprintId);
  if (p != FINGERPRINT_OK) {
    Serial.println("Error storing model.");
    return p;
  }

  Serial.println("Fingerprint stored successfully.");
  return p;
}

void captureAndSendFingerprint() {
  Serial.println("Place your finger on the sensor...");

  // Wait for a valid fingerprint image
  while (finger.getImage() != FINGERPRINT_OK) {
    delay(100);
  }

  Serial.println("Fingerprint image captured.");

  // Convert the image to a binary template in the sensor's buffer
  if (finger.image2Tz() != FINGERPRINT_OK) {
    Serial.println("Failed to convert fingerprint image to template.");
    return;
  }

  Serial.println("Fingerprint converted to template.");

  uint8_t model[512];  // Create an array to store the template model

  // Store the fingerprint model in location 2 (for example)
  if (finger.storeModel(2) == FINGERPRINT_OK) {
    Serial.println("Fingerprint model stored successfully.");

    // After storing, load the fingerprint model from location 2 into the model array
    if (finger.loadModel(2) == FINGERPRINT_OK) {
      // Print the fingerprint model data for debugging
      Serial.print("Fingerprint Model: ");
      for (int i = 0; i < 512; i++) {
        Serial.print(model[i], HEX);  // Print each byte in hexadecimal
        if ((i + 1) % 16 == 0) {
          Serial.println();
        } else {
          Serial.print(" ");
        }
      }

      // Encode the template into a Base64 string
      String base64Fingerprint = base64::encode(model, sizeof(model));

      Serial.println("Base64 Fingerprint Data Length: " + String(base64Fingerprint.length()));
      Serial.println("Base64 Fingerprint Data: " + base64Fingerprint);  // Print the Base64 string

      // Send the Base64-encoded fingerprint data to the server
      sendDataToServer(base64Fingerprint);
    } else {
      Serial.println("Failed to load fingerprint model.");
    }
  } else {
    Serial.println("Failed to store fingerprint model.");
  }
}

void sendDataToServer(String base64Fingerprint) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverURL);
    http.addHeader("Content-Type", "application/json");

    // Create JSON object
    StaticJsonDocument<1024> doc;
    doc["name"] = name;
    doc["gender"] = gender;
    doc["department"] = department;
    doc["fingerprintId"] = fingerprintId;
    doc["fingerprintImage"] = base64Fingerprint;

    String jsonData;
    serializeJson(doc, jsonData);

    // Send HTTP POST request
    int httpResponseCode = http.POST(jsonData);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Server Response: " + response);
    } else {
      Serial.println("HTTP request failed. Code: " + String(httpResponseCode));
    }

    http.end();
  } else {
    Serial.println("WiFi disconnected. Cannot send data.");
  }
}


void loop() {
  WiFiClient client = server.available();

  if (client) {
    Serial.println("New Client Connected");
    String request = client.readStringUntil('\n');
    request.trim(); // Remove any trailing whitespace or newlines

    if (request.length() > 0) {
      // Parse the received JSON data
      DynamicJsonDocument doc(512);
      DeserializationError error = deserializeJson(doc, request);

      if (!error) {
        String name = doc["name"];
        String gender = doc["gender"];
        String department = doc["department"];
        int fingerprintId = doc["fingerprintId"];

        // Display the parsed data on the Serial Monitor
        Serial.println("Data Received:");
        Serial.println("Name: " + name);
        Serial.println("Gender: " + gender);
        Serial.println("Department: " + department);
        Serial.println("Fingerprint ID: " + String(fingerprintId));

        ::name = name; // Store received name globally
        ::gender = gender; // Store received gender globally
        ::department = department; // Store received department globally
        ::fingerprintId = fingerprintId;
       
       //capture teh finger print adn isend to server 
       captureAndSendFingerprint();

      
        
      } else {
        Serial.println("Failed to parse JSON data.");
      }
    }

    delay(1);
    client.stop();
    Serial.println("Client Disconnected");
  }
}