import RPi.GPIO as GPIO

GPIO.setmode(GPIO.BCM)

GPIO.setup(17, GPIO.OUT)
GPIO.setup(18, GPIO.OUT)
GPIO.setup(22, GPIO.OUT)
GPIO.setup(23, GPIO.OUT)
GPIO.setup(27, GPIO.OUT)
GPIO.setup(24, GPIO.OUT)

p=GPIO.PWM(27, 1000)
q=GPIO.PWM(24, 1000)

p.start(65)
q.start(65)

while True:
    ch = input("f b l r q ")
    if ch == 'q':
       GPIO.output(17, False)
       GPIO.output(18, False)
       GPIO.output(22, False)
       GPIO.output(23, False)
       break
    if ch == 'f':
       GPIO.output(17, False)
       GPIO.output(18, False)
       GPIO.output(22, False)
       GPIO.output(23, True)
    if ch == 'h': 
       p.ChangeDutyCycle(100)
       q.ChangeDutyCycle(100)
       GPIO.output(17, False)
       GPIO.output(18, True)
       GPIO.output(22, False)
       GPIO.output(23, True)
    if ch == 'b':
       GPIO.output(17, True)
       GPIO.output(18, False)
       GPIO.output(22, True)
       GPIO.output(23, False)
    if ch == 'r':
       GPIO.output(17, False)
       GPIO.output(18, True)
       GPIO.output(22, False)
       GPIO.output(23, False)
    if ch == 'l':
       GPIO.output(17, False)
       GPIO.output(18, False)
       GPIO.output(22, False)
       GPIO.output(23, True)
