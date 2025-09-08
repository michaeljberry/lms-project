# API Contract

## GET /api/profile
Returns the authenticated user's profile.

## PUT /api/profile
Updates the user's profile. Accepts the following fields:
- `first_name` (string, required)
- `last_name` (string, required)
- `bio` (string)
- `learning_objectives` (string)
- `skills` (array of strings)
- `interests` (array of strings)
- `badges` (array of strings)
- `certifications` (array of strings)
- `accessibility_preferences` (array)
- `timezone` (string)
- `location` (string)
- `consent_marketing` (boolean)
- `consent_research` (boolean)
- `avatar` (image upload)

## Permission Check
Permissions are resolved using role hierarchies and optional course overrides. Use the `User::can($permission, $course)` helper in application code.
