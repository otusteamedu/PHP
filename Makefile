#-------
dev-backend-short-deploy:
	ansible-playbook run-backend.yml --extra-vars="go_action=short-deploy target_hosts=dev"

dev-backend-full-deploy:
	ansible-playbook run-backend.yml --extra-vars="go_action=full-deploy target_hosts=dev"

