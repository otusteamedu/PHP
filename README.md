# Инфо

В `docker-compose.yml` приведен вариант реализации layer 7 балансировки c использованием nginx-upstream.

В `k8s.ingress.yml` приведен вариант реализации layer 7 балансировки с использованием Kubernetes и Nginx-Ingress.
По сути это аналог предыдущего варианта, но с динамическим конфигом nginx.
https://kubernetes.github.io/ingress-nginx/how-it-works/

В `k8s.yml` приведен вариант балансировки с использованием Kubernetes LoadBalancer.
По дефолту layer 4, но в зависимости от сервис провайдера могут быть дополнительные возможности.
Примеры:
https://www.digitalocean.com/docs/kubernetes/how-to/configure-load-balancers/
https://cloud.yandex.ru/docs/managed-kubernetes/operations/create-load-balancer#advanced

