#this file basically has functions that requires system commands to be executed

#os is imported to run commands
import os

#setting base directory to root of machine
os.chdir(os.getenv("HOME"))

# all the functions below are called
# from app.py file on appropriate triggers
# associated commands are run using the os.system function

def open_MS_Word():
    print("opening ms word")
    os.system("open '/Applications/Microsoft Word.app/Contents/MacOS/Microsoft Word'")

def open_document(path):
    print("opening document")
    os.system("open 'Desktop/Internet of Things/project/files/test_data.docx'")

def open_calender():
    print("opening calender")
    os.system("open -a Calendar")

def sleep_mac():
    print("Sleeping mac")
    os.system("osascript -e 'tell app \"System Events\" to sleep'")

def shut_down_mac():
    print("shutting down mac")
    os.system("osascript -e 'tell app \"System Events\" to shut down'")
