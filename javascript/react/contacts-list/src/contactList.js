import React, {Component} from "react";
import Contact from "./contact";
import "./contactList.css";

class ContactList extends Component {

    constructor(props) {
        super(props);

        this.state = {
            items: []
        }

        this.addItem = this.addItem.bind(this);
        this.deleteItem = this.deleteItem.bind(this);

    }

    addItem(e) {
        var itemArray = this.state.items;

        if (this._inputElementA.value !== "" && this._inputElementB.value !== "" && this._inputElementC.value !== "") {
            itemArray.unshift({
                text: this._inputElementA.value,
                text2: this._inputElementB.value,
                text3: this._inputElementC.value,
                key: Date.now()
            });

            this.setState({
                items: itemArray
            });

            this._inputElementA.value = "";
            this._inputElementB.value = "";
            this._inputElementC.value = "";
        }

        //every time we enter an item the page would get re-rendered
        //could also just not submit the form and do an onclick right?
        e.preventDefault();
    }

    deleteItem(key) {
        var filteredItems = this.state.items.filter(function (item) {
            return (item.key !== key);
        });

        this.setState({
            items: filteredItems
        });
    }

    render() {
        return (
            <div className="contactListMain">
                <div className="header">
                    <h1>Contact List</h1>
                    <form onSubmit={this.addItem}>
                        Name:
                        <br/>
                        <br/>
                        <input ref={(a) => this._inputElementA = a} placeholder="Enter name">
                        </input>
                        <br/>
                        <br/>
                        Email:
                        <br/>
                        <br/>
                        <input ref={(b) => this._inputElementB = b} placeholder="Enter email">
                        </input>
                        <br/>
                        <br/>
                        Phone Number:
                        <br/>
                        <br/>
                        <input ref={(c) => this._inputElementC = c} placeholder="Enter phone number">
                        </input>
                        <br/>
                        <br />
                        <button type="submit">Add to Contact List</button>
                    </form>
                </div>
                <Contact entries={this.state.items} delete={this.deleteItem}/>
            </div>
        );
    }
}

export default ContactList;