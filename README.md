# PassCard

This tool was inspired by the [“DSIN Passwortkarte”](https://www.sicher-im-netz.de/dsin-passwortkarte).

It is fully published as open source without any waranty. If using the tool, please be aware of the rules to use it securely. Especially, if you print your passcard ... **don't ever mark your password!** It's meant to be remembered by you – or at least the “path” on the card you used to create it.

The PHP app is located in the `app` directory of this repo. The repo itself is extended to build a (Docker) container image to allow you to run your own copy of the software out of the box.

For special usage of the tool, please see the [application `README.md`](app/README.md) file for further information.

## Demo

A running instance of this tool can be found at [passcard.dev-ops.fk.ms](https://passcard.dev-ops.fk.ms). There is one special config deployed - so if you head over to [https://passcard.dev-ops.fk.ms/?conf=lowercase](https://passcard.dev-ops.fk.ms/?conf=lowercase), you'll be presented a passcard only using the lowercase alphabet `a-z` without any additions.

## last built

2025-01-21 02:35:57
