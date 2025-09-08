# Permission Matrix

| Role       | Permissions                 | Notes |
|------------|-----------------------------|-------|
| admin      | manage_roles (allow) <br> manage_permissions (allow) <br> manage_profiles (allow) | inherits user |
| user       | manage_profiles (allow)    |       |
| instructor | view_course (deny)         | inherits student |
| student    | view_course (allow)        |       |

Explicit deny takes precedence over allow. Course level overrides can allow or deny individual permissions per user.
