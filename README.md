Frequently Questioned Answers:

Q: What is it?
A: This is for running the ZenPackBuilderDocker[1] container with a (crappy) web ui. Right now it looks like a bad anglefire page from 1996, but it's a (sorta) funtioning PoC.

Q: Why?
A: Because I thought it would be fun. I was mostly wrong.

Q: How do I use it?
A1: Well, there's a couple ways. If you have an on-prem zenoss system you can add the template in control center, and then deploy an applciation. Click the start button.
A2: You can do a docker pull linkslice/zenpacklab:latest on any docker host with access to the web. Then run `docker run -p 42069:42069/tcp -it linkslice/zenpacklab:latest`
A3: You can clone the repo and run `docker build -t linkslice/zenpacklab:latest .` At which point you can run the above `run` command.
After doing any of the 3 a horrible web page will appear that will allow you to generate a zenpack with your custom scripts and/or nagios plugins inside.

Q: Should I use this?
A: No, no you shouldn't.

Although you shouldn't use this in any environment you care about, I'd still welcome bug fixes and PRs. I mostly just wanted to get it (mostly) working and pushed onto the internet.

[1] https://github.com/linkslice/ZenPackBuilderDocker
