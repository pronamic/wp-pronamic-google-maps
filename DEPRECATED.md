# ⚠️ Plugin Archived / Deprecated

**Status:** This plugin is archived and no longer maintained.

**Deprecated:** August 31, 2026

## Reason for Archival

This plugin has been temporarily removed from the WordPress.org Plugin Directory due to a **critical security vulnerability** (Authorization/Capability Check Issue - CWE-862, CVSS 5.4).

### Vulnerability Summary

An authenticated AJAX handler (`wp_ajax_pgm_geocode`) was accepting caller-supplied post IDs and coordinates without proper authorization checks. This allowed:

- Unauthorized subscribers to modify Google Maps metadata on posts they shouldn't have access to
- Potential disclosure of protected post information (IDs, titles, addresses)
- Coordinate changes visible on public maps without proper permissions

### What Was Affected

- **Version affected:** 2.4.2 and potentially earlier versions
- **Vulnerability type:** Missing capability and nonce verification
- **CVSS Score:** 5.4 (Medium - Network accessible, Low privileges required)

## For Current Users

If you are currently using this plugin:

1. **Deactivate and delete** the plugin immediately
2. **Review audit logs** for any unauthorized changes to post metadata
3. **Consider alternatives** for Google Maps integration in your WordPress site
4. **Update your WordPress** installation to ensure security patches are applied

## Security Findings

The vulnerability allowed unauthorized access due to:
- ✗ No nonce verification
- ✗ No capability checks (`edit_post`)
- ✗ No post type validation
- ✗ No permission checks for reading post data

## Archive Decision

Due to the critical nature of the security issue and the plugin's dependency on the deprecated Google Maps API, we have decided to archive this plugin rather than maintain it. This ensures that no users accidentally use an insecure version.

## Alternatives

Consider these alternatives for Google Maps integration:
- Modern map plugins from the WordPress.org directory
- Custom implementations using the current Google Maps API
- Other actively maintained map solutions

---

**For inquiries:** This decision was made in August 2026 to prioritize WordPress ecosystem security.
