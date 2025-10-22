# ImperiaMuCMS License Server (C#)

This project delivers a Windows desktop application that emulates the ImperiaMuCMS
license endpoints (`apiversion.php`, `?check`, `?info`, `?activate`) and exposes a
friendly interface to manage customers and premium-module entitlements. The server
uses the same AES-256-CBC routine that the CMS expects, so no change to the PHP
code is required once the CMS points to this service.

## Highlights

- Windows Forms interface to create, edit, and delete license owners.
- Per-user module matrix: enable/disable modules and adjust license keys, usage IDs,
  statuses, expirations, and purchase names for each module.
- Built-in log viewer, editable HTTP prefixes, and default custom-field templates.
- AES-encrypted responses matching the CMS `decodeLicData()` implementation.

## Requirements

- Windows with the .NET 6.0 (or newer) SDK installed.
- The CMS must resolve `__IMPERIAMUCMS_LICENSE_SERVER__` (default
  `http://imperiamucms.com/`) to the machine that runs this application. You can
  update the constant inside `includes/imperiamucms.php` or override the hostname
  via DNS/hosts.

## Running the application

```bash
# From the repository root
 dotnet run --project tools/license-server/LicenseServer.csproj
```

> **Tip:** pass a custom configuration path as the last argument if you keep the
> JSON in a different location:
>
> ```bash
> dotnet run --project tools/license-server/LicenseServer.csproj -- C:\licenses\license-config.json
> ```

When the UI appears, the server starts automatically and listens on the prefixes
defined in the configuration file.

## Managing users and modules

1. Use the left-hand list to select, add, or remove users. The detail pane lets you
   edit the main license key, status, expiration, purchase name, and custom fields.
2. The **Módulos** grid lists every premium component. Check a module to provision a
   license record; edit the right-hand form to adjust the generated key, usage ID,
   status, expiration, purchase name, and custom fields.
3. The **Servidor** section lets you edit the HTTP prefixes and the default custom
   field template. Saving restarts the embedded HTTP listener with the new prefixes.
4. The **Logs** panel prints request errors and startup/shutdown information from the
   background listener.

Remember to click **Salvar** after making changes. The application writes the JSON
and refreshes the in-memory store, so the HTTP responses immediately reflect the
new state.

## Configuration format

All data lives in [`license-config.json`](./license-config.json). The schema differs
from the earlier console tool and is centered around users and module definitions:

- `prefixes`: HTTP prefixes understood by `HttpListener` (for example
  `http://*:5000/`).
- `defaultCustomFields`: template array applied to every license when no specific
  override is provided.
- `modules`: catalog of premium features with default keys/names. The UI ships with
  entries for the official ImperiaMuCMS premium modules (Bug Tracker, Market, Wheel
  of Fortune, etc.).
- `users`: collection of license owners. Each user contains:
  - `name` and `identifier` (the CMS sends the identifier in the `identifier`
    parameter).
  - `coreLicense`: base license information (key, usageId, status, expires,
    purchaseName, customFields).
  - `modules`: array of module assignments (`moduleId`, `key`, `usageId`, `status`,
    `expires`, `purchaseName`, `customFields`).

The UI reads and writes this JSON file directly; you can also edit it manually if
needed.

## Integrating with ImperiaMuCMS

1. Point `__IMPERIAMUCMS_LICENSE_SERVER__` in `includes/imperiamucms.php` (or the
   equivalent DNS record) to the host where this license application runs.
2. Ensure the CMS-side license files reference the same keys and identifiers defined
   for the selected user and modules.
3. Launch the C# application and keep it running while the CMS performs remote
   license checks. As soon as the server starts, the premium modules unlocked in the
   UI become available on the website.

## Notes

- `HttpListener` requires administrative privileges to bind to privileged ports
  (<1024). Use a higher port or register the prefix with `netsh http add urlacl` on
  Windows.
- The sample configuration includes permissive custom fields; adapt them to match
  your production IP and domain restrictions.
