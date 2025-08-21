#!/bin/bash

# WhatsApp Webhook Testing Script for Laundry Management System
# Usage: chmod +x test-webhook.sh && ./test-webhook.sh

BASE_URL="http://127.0.0.1:8000"
WEBHOOK_URL="$BASE_URL/api/whatsapp/webhook"

echo "🧺 Testing WhatsApp Webhook for Laundry Management System"
echo "========================================================="
echo ""

# Test 1: Valid order message - cuci kering
echo "Test 1: Testing cuci kering order..."
curl -X POST "$WEBHOOK_URL" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "6281234567890",
    "message": "Pesan cuci kering 5kg",
    "timestamp": "2025-08-20 08:30:00"
  }' \
  -w "\nStatus: %{http_code}\n" \
  -s
echo ""

# Test 2: Valid order message - setrika only
echo "Test 2: Testing setrika order..."
curl -X POST "$WEBHOOK_URL" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "6289876543210", 
    "message": "Pesan setrika 3 potong pakaian",
    "timestamp": "2025-08-20 09:15:00"
  }' \
  -w "\nStatus: %{http_code}\n" \
  -s
echo ""

# Test 3: Valid order message - cuci + setrika
echo "Test 3: Testing cuci setrika combo..."
curl -X POST "$WEBHOOK_URL" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "6281122334455",
    "message": "Pesan cuci setrika 2kg",
    "timestamp": "2025-08-20 10:00:00"
  }' \
  -w "\nStatus: %{http_code}\n" \
  -s
echo ""

# Test 4: Valid order message - dry cleaning
echo "Test 4: Testing dry cleaning order..."
curl -X POST "$WEBHOOK_URL" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "6285566778899",
    "message": "Pesan dry cleaning 4 potong",
    "timestamp": "2025-08-20 11:00:00"
  }' \
  -w "\nStatus: %{http_code}\n" \
  -s
echo ""

# Test 5: Invalid message (should not create order)
echo "Test 5: Testing invalid message (should not create order)..."
curl -X POST "$WEBHOOK_URL" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "6281234567890",
    "message": "Halo, apakah toko buka?",
    "timestamp": "2025-08-20 12:00:00"
  }' \
  -w "\nStatus: %{http_code}\n" \
  -s
echo ""

# Test 6: Alternative order format
echo "Test 6: Testing alternative order format..."
curl -X POST "$WEBHOOK_URL" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "6287654321098",
    "message": "Order laundry cuci kering untuk 7 kg pakaian",
    "timestamp": "2025-08-20 13:00:00"
  }' \
  -w "\nStatus: %{http_code}\n" \
  -s
echo ""

# Test 7: Short message format
echo "Test 7: Testing short message format..."
curl -X POST "$WEBHOOK_URL" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "6281357924680",
    "message": "cuci 2kg",
    "timestamp": "2025-08-20 14:00:00"
  }' \
  -w "\nStatus: %{http_code}\n" \
  -s
echo ""

# Test 8: Complex message with additional text
echo "Test 8: Testing complex message..."
curl -X POST "$WEBHOOK_URL" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "6282468135790",
    "message": "Halo, saya mau pesan cuci setrika untuk 6 potong baju. Kapan bisa diambil?",
    "timestamp": "2025-08-20 15:00:00"
  }' \
  -w "\nStatus: %{http_code}\n" \
  -s
echo ""

echo "========================================================="
echo "✅ Testing completed!"
echo ""
echo "📋 Check results:"
echo "1. Visit $BASE_URL/pesanan to see created orders"
echo "2. Visit $BASE_URL/pelanggan to see auto-created customers"
echo "3. Visit $BASE_URL/dashboard for statistics"
echo ""
echo "💡 Expected behavior:"
echo "- Tests 1,2,3,4,6,7,8 should create orders (HTTP 200)"
echo "- Test 5 should NOT create order but return success (HTTP 200)"
echo "- All valid orders should auto-create customers if not exist"
