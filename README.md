## Echo Chamber - A laravel helm chart test

This is a sample laravel application setup to be deployed to a kubernetes 
cluster

## TODO:
- [x] Get nginx + php-fpm serving the application
- [x] Get laravel optimizations working
- [x] Get queue worker going
- [x] Get laravel scheduled jobs working
- [ ] Update entrypoint to allow listening to one or more queues
- [ ] Update chart to allow running several queue deployments working on 
      different queues



## Helm v2 plugins

Install the following plugins:
- [helm-tiller](https://github.com/rimusz/helm-tiller)
- [helm-secrets](https://github.com/futuresimple/helm-secrets)

```shell script
helm plugin install https://github.com/rimusz/helm-tiller
helm plugin install https://github.com/futuresimple/helm-secrets
```

## Ensure cluster has nginx-ingress running
```shell script
helm tiller start

helm install stable/nginx-ingress \
  --name nginx-ingress \
  --set controller.publishService.enabled=true

exit
```

