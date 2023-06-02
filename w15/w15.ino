#include <WiFi.h>
#include <HTTPClient.h>

const char* ssid = "6412";
const char* password = "20020920";
const char* serverUrl = "http://192.168.1.101/save_data.php";
const int analogInPin = 34;  // 定義可變電阻連接到的腳位

void setup() {
  Serial.begin(115200);
  
  // Connect to Wi-Fi network
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
}

void loop() {

  // Pass the sensor value as a POST parameter
  int sensorValue = analogRead(analogInPin);  // Read the value of the variable resistor
  Serial.println(String(sensorValue));

   // 创建HTTPClient对象
  HTTPClient http;
  
  // 添加要发送的数据
  String postData = "value=" + String(sensorValue);
  
  // 发送POST请求
  http.begin(serverUrl);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpResponseCode = http.POST(postData);
  
  if (httpResponseCode > 0) {
    String response = http.getString();

  } else {
    Serial.print("Error code: ");
    Serial.println(httpResponseCode);
  }
  
  http.end();


  delay(5);

  
}
