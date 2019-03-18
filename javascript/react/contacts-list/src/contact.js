import React, {Component} from "react";

class Contact extends Component {
    constructor(props) {
        super(props);

        this.createContact = this.createContact.bind(this);
        this.delete = this.delete.bind(this);

    }

    delete(key) {
        this.props.delete(key);
    }

    createContact(item) {
        return (
            <div>
            <li onClick={() => this.delete(item.key)} key={item.key}>
                <p><strong>Name: </strong>{item.text}</p>
                <p><strong>Email: </strong>{item.text2}</p>
                <p><strong>Phone: </strong>{item.text3}</p>
            </li>
                <br />
            </div>
        );
    }

    render() {
        var contactEntries = this.props.entries;
        var listContacts = contactEntries.map(this.createContact);
        return (
            <ul className="theList">
                {listContacts}
            </ul>
        );
    }
};

export default Contact;