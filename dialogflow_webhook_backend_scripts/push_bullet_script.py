##push pulled api was used to send pushes to other pc:
# basically for fulfilling the requirement of controlling multiple PC's

from pushbullet import PushBullet

#unique id to send data
pb = PushBullet('o.qttbnrlCEJkwTQvu91RZDZeEbBxUYtKK')

def push_to_chirag():
    push = pb.push_note("open word chirag", "incoming from toor")
    print("pushed to push note for chirag")

def push_type_command(TypeOnChiragPc):
    data_to_push = TypeOnChiragPc['result']['parameters']['any']
    push = pb.push_note("type chirag", data_to_push)
