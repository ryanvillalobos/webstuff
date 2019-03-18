var express = require('express');
var contactRouter = express.Router();
var Contact = require('../../models/contact');

contactRouter.use('/', (req, res, next) => {
    console.log("I run first before I retrieve all the contacts")
    next()
})

contactRouter.use('/:email', (req, res, next) => {
    Contact.findOne({emailAddress: req.params.email}, (err, contact) => {
        if (err)
            res.status(500).send(err)
        else {
            console.log(req.params);
            req.contact = contact;
            next()
        }
    })
})
contactRouter.route('/')
    .get((req, res) => {
        Contact.find({}, (err, contacts) => {
            res.json(contacts)
        })
    })
    .post((req, res) => {
        let contact = new Contact(req.body);
        contact.save()
        res.status(201).send(contact)
    });


contactRouter.route('/:email')
    .get((req, res) => {
        res.json(req.contact)
    })
    .put((req, res) => {

        // when using middleware
        req.contact.fullName = req.body.fullName;
        req.contact.phoneNumber = req.body.phoneNumber;
        req.contact.emailAddress = req.body.emailAddress;
        req.contact.save()
        res.json(req.contact)

    })
    .delete((req, res) => {
        // with middleware
        req.contact.remove(err => {
            if (err) {
                res.status(500).send(err)
            } else {
                res.status(204).send('removed')
            }

        })
    })


module.exports = contactRouter;