UPDATE account.account
SET authorities = authorities + {'ROLE_ADMIN'}
WHERE id = '98cc1633-bd45-4ace-a3a7-a26106b865ec'
AND username = 'admin@example.com';