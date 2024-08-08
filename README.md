Frequently Questioned Answers:

Q: What is it?<br>
A: This is for running the ZenPackBuilderDocker[1] container with a (crappy) web ui. Right now it looks like a bad anglefire page from 1996, but it's a (sorta) funtioning PoC.

Q: Why?<br>
A: Because my GF went on vacation and I thought it would be more fun than binge drinking. I was mostly wrong.

Q: Should I use this?<br>
A: No, no you shouldn't.<br>

Q: How do I use it?<br>
A1: Well, there's a couple ways. If you have an on-prem zenoss system you can add the template (ZenPackLabUbuntu.json or ZenPackLabCentos.json) in control center, and then deploy an application. Click the start button.<br>
A2: You can do a `docker pull linkslice/zenpacklab:<tag>` on any docker host with access to the web. Then run `docker run -p 42069:42069/tcp -it linkslice/zenpacklab:<tag>`<br>
A3: You can clone the repo and run `docker build -t linkslice/zenpacklab:<tag> -f Ubuntu/Dockerfile .` At which point you can run the above `run` command.<br>
After doing any of the 3 a horrible web page will appear that will allow you to generate a zenpack with your custom scripts and/or nagios plugins inside.<br>

Q: Should I use this?<br>
A: No, no you shouldn't.<br>

Q: Which `<tag>` should I use?<br>
A: If you're running an on-prem version 6.7 or earlier you should use `centos`. If later versions of cloud you should use `ubuntu`.<br>

Q: Should I use this?<br>
A: Bro, we've been over this<br>

Although you shouldn't use this in any environment you care about, I'd still welcome bug fixes and PRs (especially ui fixes). I mostly just wanted to get it working and pushed onto the internet.

[1] https://github.com/linkslice/ZenPackBuilderDocker

Example Usage:<br>
![](https://github.com/linkslice/ZenPackLab/blob/main/ZenPackLab.gif)
