# Instructions to install SSL certificate
//TODO
1. Create Secret
2. Create Front-End Route - External Traffic
TLS Termination - Edge
Insecure Traffic - Redirect
Certificate - file - Secret mapping 
Private key - file - Secret mapping 
CA Certificate - File L1KChain - Secret mapping
3. Verify SSO (KeyCloak) settings - https://sso-dev.pathfinder.gov.bc.ca/


These instructions assume you have installed the [OpenShift scripts](https://github.com/BCDevOps/openshift-developer-tools/blob/master/bin/README.md) and that they are accessible via your PATH environment variable.

You will also need to use the [docker/manage.sh](../docker/README.md)  to build the images locally.
# Param management
Run the genParams.sh whenever a new template is created or a change adds a new param
```
genParams.sh
```
Generate pipeline param files whenever you have a pipeline script to test and deploy.
```
genPipelineParams.sh
```

# Build
```
genBuilds.sh     # when you need to add a new build artifact 
genBuilds.sh -u  # when you have want to deploy modified param

```

# Deployment
```
getDepls.sh       # when you need to add a new deployment artifact
getDepls.sh -u    # when you need want to deploy a modified param

```

# Pipeline
Pipeline builds are managed by the build script phase.

