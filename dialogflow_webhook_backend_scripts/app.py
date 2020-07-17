# Flask is used for making a RESTFULL API
from flask import Flask, json, request, make_response, jsonify
app = Flask(__name__)

# following imports are for different scripts in the same package
# diffrent scripts were made to keep code clean
from system_commands import open_MS_Word, open_calender
from word_script import write_into_document, first_paragraph_italic, first_paragraph_bold, \
    append_into_document, add_heading_into_document

# push pulled api was used to send pushes to other pc:
# basically for fulfilling the requirement of controlling multiple PC's
from push_bullet_script import push_to_chirag, push_type_command

@app.route('/')
def hello_world():
    push_to_chirag()
    return 'Hello World!'


# this method is linked with dialog flow fulfilment api. Dialog flow send data in JSOP Format to this link
# we used a package named ngrok to tunnel this local host to outside internet
@app.route('/test', methods=['POST'])
def test():
    data__recieved = request.get_json(silent=True, force=True)
    #parsing of json data recieved
    intent_triggered = data__recieved['result']['metadata']['intentName']
    print("intent triggered: ",intent_triggered)

    #default return meassge is no trigger is matcehed
    speech = "Sorry! what was that?"

    #the following line of code calls function and passes data recived to it
    #string returned will be returned back to dialog flow
    speech = trigger_command_logic(intent_triggered, speech, data__recieved)

    #following function constructs response to be sent back to dialogflow
    response = prepareRespose(speech)
    print("responding: ",response)
    json_response = jsonify(response)
    #following lines converts rsponse to json format and return it
    print(json_response)
    return json_response


# this function basically has if else conditions to
# match the right trigger and call the function associated with it
def trigger_command_logic(intent_triggered, speech, data__recieved):
    if intent_triggered == "WordManipulation":
        speech = "Yes we have MS Word installed on our machine"
    elif intent_triggered == "WordManipulation-Open":
        open_MS_Word()
        speech = "Opening Microsoft Word"
    elif intent_triggered == "WordManipulation:Type":
        speech = "Typing"
        write_into_document(data__recieved)
    elif intent_triggered == "PushToPC":
        speech = "Opening MS Word on Chirag's PC"
        push_to_chirag()
        speech = "Typing on Chirag's MS Word on Chirag's PC"
    elif intent_triggered == "WordManipulation:Style - Italic":
        speech = "Making text Italic"
        first_paragraph_italic()
    elif intent_triggered == "WordManipulation:Style - Bold":
        speech = "Making text bold"
        first_paragraph_bold()
    elif intent_triggered == "TypeOnChiragPc":
        speech = "typing on chirag's pc"
        push_type_command(data__recieved)
    elif intent_triggered == "SoftwaresInstalled -Calender":
        speech = "Opneing apple calender"
        open_calender()
    elif intent_triggered == "SoftwaresInstalled - MSWord":
        speech = "Opening ms Word"
        open_MS_Word()
    elif intent_triggered == "WordManipulation:AddParagraph":
        speech = "Adding you text"
        append_into_document(data__recieved)
    elif intent_triggered == "WordManipulation:AddHeading":
        speech = "Adding Heading"
        add_heading_into_document(data__recieved)
    else:
        speech = "Sorry! what was that?"
    return speech


#preapres response in format dialogflow requires and returns
def prepareRespose(speech):
    return {
        "speech":speech,
        "displayText":speech,
        "source":"Web Hook"
    }


if __name__ == '__main__':
    app.run(debug=True)
