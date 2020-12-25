```
# cd hw-2-2/task2

cp .env.example .env

docker-compose up -d

```

#test
```
# run while sleep 0.5; do curl -k https://localhost:<BALANCER_PORT>; done

# e.g.
while sleep 0.5; do curl -k https://localhost:90; done
```

or

```
sudo bash -c "echo \"192.168.9.2 hw-2-2.task2.balancer.docker\" >> /etc/hosts"
while sleep 0.5; do curl -k https://hw-2-2.task2.balancer.docker; done
```

or

```
sudo bash -c "echo \"127.0.0.1 hw-2-2.task2.balancer.docker\" >> /etc/hosts"
while sleep 0.5; do curl -k https://hw-2-2.task2.balancer.docker:90; done
```
