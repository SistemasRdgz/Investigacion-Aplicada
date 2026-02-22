# Aplicación PHP con Login simulado y Docker

Descripción breve:
Este proyecto consiste en el desarrollo y despliegue de una aplicación web en PHP que implementa un sistema básico de autenticación utilizando variables de sesión.

La aplicación:

Simula un sistema de login (sin base de datos).

Está empaquetada en una imagen Docker.

Es desplegada en Kubernetes con múltiples réplicas.

Implementa balanceo de carga.

Incluye escalado horizontal automático (HPA).

1. Desarrollo de la Aplicación Web

 Funcionalidad Implementada

La aplicación incluye:

Login simulado con credenciales definidas en el código.

Uso de $_SESSION para mantener la sesión activa.

Redirección a un dashboard tras autenticación exitosa.

Protección de rutas mediante validación de sesión.

Cierre de sesión con destrucción de sesión activa.


Credenciales Simuladas

Usuario:LIS
Contraseña: $nvestigacionUDB

Estructura de Archivos

```codigo
index.php            → Formulario de login
authenticate.php     → Validación de credenciales
dashboard.php        → Página protegida (requiere sesión)
logout.php           → Cierre de sesión
Dockerfile           → Configuración de la imagen Docker
README.md            → Documentación del proyecto
```
2. Empaquetado en Docker
La aplicación se empaqueta utilizando una imagen base oficial de PHP con Apache.

```dockerfile
FROM php:8.2-apache

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
```

Construcción de la Imagen

Ejecutar en la carpeta del proyecto:

```bash
docker build -t php-login-app .
```

Acceder desde el navegador:

```bash
http://localhost:8080
```

3. Despliegue en Kubernetes

Se configura un entorno de Kubernetes para ejecutar múltiples réplicas de la aplicación, garantizando alta disponibilidad.
Deployment (2 Réplicas)

Archivo: deployment.yaml

```yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: php-login-deployment
spec:
  replicas: 2
  selector:
    matchLabels:
      app: php-login
  template:
    metadata:
      labels:
        app: php-login
    spec:
      containers:
      - name: php-login-container
        image: php-login-app
        imagePullPolicy: Never
        ports:
        - containerPort: 80
```

Aplicar configuración:

```Bash
kubectl apply -f deployment.yaml
```

Verificar pods:

```Bash
kubectl get pods
```
Función del Deployment

Mantiene siempre 2 réplicas activas.

Si un pod falla, Kubernetes lo recrea automáticamente.

Garantiza disponibilidad continua

4. Implementación de Balanceo de Carga

Se utiliza un Service de tipo LoadBalancer para distribuir el tráfico entre las réplicas.

```yaml
apiVersion: v1
kind: Service
metadata:
  name: php-login-service
spec:
  type: LoadBalancer
  selector:
    app: php-login
  ports:
    - port: 80
      targetPort: 80
```

Aplicar:
```Bash
kubectl apply -f service.yaml
```

Verificar:
```Bash
kubectl get services
```
Acceder a Minikube:
```Bash
minikube service php-login-service
```

¿Cómo funciona el balanceador de carga?

El Service:

Recibe el tráfico externo.

Distribuye las solicitudes de forma equitativa entre los pods.

Detecta pods activos automáticamente.

Si un pod falla, deja de enviar tráfico a esa instancia.

Esto garantiza alta disponibilidad y distribución eficiente de solicitudes.

5. Escalado Horizontal (HorizontalPodAutoscaler)

Se implementa un sistema de escalado automático basado en el uso de CPU.

```yaml
apiVersion: autoscaling/v2
kind: HorizontalPodAutoscaler
metadata:
  name: php-login-hpa
spec:
  scaleTargetRef:
    apiVersion: apps/v1
    kind: Deployment
    name: php-login-deployment
  minReplicas: 2
  maxReplicas: 5
  metrics:
  - type: Resource
    resource:
      name: cpu
      target:
        type: Utilization
        averageUtilization: 50
        
```


```bash
kubectl apply -f hpa.yaml
 ```

```bash
kubectl get hpa
 ```

Funcionamiento del Escalado

Kubernetes monitorea el uso de CPU.

Si el consumo supera el 50%, aumenta automáticamente el número de pods.

Puede escalar hasta un máximo de 5 réplicas.

Si la carga disminuye, reduce el número de pods.

El balanceador de carga distribuye automáticamente el tráfico hacia las nuevas réplicas.


Flujo General de Funcionamiento

El usuario accede a la aplicación.

El Service recibe la solicitud.

El LoadBalancer distribuye el tráfico entre los pods.

El Deployment mantiene las réplicas activas.

Si aumenta la demanda, el HPA crea más pods.

Si un pod falla, Kubernetes lo reemplaza automáticamente.


Este proyecto demuestra:

Implementación de autenticación básica en PHP.

Empaquetado portable mediante Docker.

Orquestación de contenedores con Kubernetes.

Balanceo de carga.

Escalabilidad horizontal automática.

Alta disponibilidad de la aplicación.

La arquitectura permite que la aplicación pueda adaptarse dinámicamente a la demanda de tráfico y mantenerse operativa ante fallos.
