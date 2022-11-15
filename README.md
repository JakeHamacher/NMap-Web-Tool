# NMap-Web-Tool
This is an nmap tool which gives nmap a simple GUI on the browser.

**Requirements**

Libcap Library which can be installed with the command -
`sudo apt-get install libcap2-bin`

then, run the command -
`sudo setcap cap_net_raw,cap_net_admin,cap_net_bind_service+eip $(which nmap)`

This allows for nmap to run without root/sudo priviledges (required for most nmap commands)

**Use**

Enter the IP or the IP range you wish to scan into the indicated box.
An IP range will be in the format of XXX.XXX.XXX-YYY.XXX-YYY, where X is the low end of the range and Y is the high end.
and example range would be, 192.168.0.1-100, or 10.127.1-255.1-255.

  **Options**
  
  SYN -sS (Default) - 
  This is the default scan,it can be performed quickly, scanning thousands of ports per second on a fast network not hampered by restrictive firewalls. It is also relatively unobtrusive and stealthy since it never completes TCP connections
  
  CONNECT() -sT - 
  Nmap has less control over the high level connect call than with raw packets, making it less efficient. There is also a chance of being logged or noticed by an IDS. Less stealthy than SYN.
  
  ACK -sA - 
  This scan never determines open (or even open|filtered) ports. It is used to map out firewall rulesets, determining whether they are stateful or not and which ports are filtered.
  
  Window - 
  Window scan is exactly the same as ACK scan except that it exploits an implementation detail of certain systems to differentiate open ports from closed ones, rather than always printing unfiltered when a RST is returned.
  
  Maimon -sM - 
  Maimon sends FIN/ACK probe packets. A RST packet should be generated in response to such a probe whether the port is open or closed.
  
  IP Protocol - 
  IP protocol scan allows you to determine which IP protocols (TCP, ICMP, IGMP, etc.) are supported by target machines. This isn't technically a port scan, since it cycles through IP protocol numbers rather than TCP or UDP port numbers.
  
  OS Detection -A - 
  To enable this feature simply click on the checkbox before running your scan. One of Nmap's best-known features is remote OS detection using TCP/IP stack fingerprinting. Nmap sends a series of TCP and UDP packets to the remote host and examines practically every bit in the responses. After performing dozens of tests such as TCP ISN sampling, TCP options support and ordering, IP ID sampling, and the initial window size check, Nmap compares the results to its nmap-os-db database of more than 2,600 known OS fingerprints and prints out the OS details if there is a match.
