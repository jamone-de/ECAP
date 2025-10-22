# ECAP / 1.0  
### Ethical Crawler Agreement Protocol  
*A Human-First Standard for Responsible Automation*  

**Publisher:** Adnan Schulze-Hüneke (JamOne-DE)  
**Project:** JamOne AntiCrawl Shield (Implementation Reference)  
**Version:** 1.0 – October 2025  
**Status:** Public Reference Specification – Initial Release  

---

## Abstract
ECAP / 1.0 defines a transparent, auditable, and privacy-aware handshake between automated crawlers and web servers.  
It re-establishes the lost digital handshake once represented by *robots.txt*, replacing blind extraction with mutual consent and verifiable ethics.  
The protocol extends HTTP with minimal new semantics so any site can declare its policy and receive signed consent tokens before data is taken.

---

## 1 Purpose and Principles
- **Transparency** — Servers declare clear usage and consent rules.  
- **Accountability** — Each consent event is cryptographically signed and verifiable.  
- **Simplicity** — Works with existing HTTP(S) infrastructure.  
- **Fairness** — Allows non-commercial and commercial access under explicit terms.  
- **Privacy by Design** — Collects only essential forensic metadata.  
- **Defensive Integrity** — Supports legal, ethical honeypots and decoys for proof without harm.

---

## 2 Terminology
| Term | Meaning |
|------|----------|
| Server | Website or API offering resources under ECAP |
| Crawler | Automated agent (bot, spider, AI indexer) |
| Policy | JSON document describing access rights |
| Consent Token | Signed proof of granted access |
| Honeypot | Controlled decoy endpoint for forensic verification |
| Log Envelope | Signed record of each interaction |

---

## 3 Handshake Flows

### 3.1 Basic Consent Request
1️⃣ Crawler requests `GET /resource`.  
2️⃣ Server replies `401 Unauthorized` + `X-ECAP-Status: 401C` and policy JSON body.  
3️⃣ Crawler posts signed consent to `/ecap/consent`.  
4️⃣ Server verifies and issues JWT token + logs event.  

### 3.2 Advance Announcement
```http
POST /ecap/announce
Content-Type: application/ecap+json
Server returns policy and optional challenge.
```

### 3.3 Interactive Consent
Server may require human approval (e.g. legal agreement or payment flow).
Response contains `follow_up: interactive`; crawler waits for manual authorization.

### 3.4 Silent Fallback / Honeypot
If no ECAP support, server may block (403), throttle, or serve forensic decoy content.

---

## 4 Example Handshake Dialogs (for Humans and Machines)
**Example A — Neutral / Ethical**  
🤖 Hello digital visitor.  
Would you like to explore our site for information without monetizing the content or using it for training?  
✅ Yes – welcome. Please cite the source.  
❌ No – commercial or training use requires a license.  

**Example B — Commercial / Revenue Share**  
🤖 Do you intend to use our data commercially or feed it into AI models?  
Then confirm that you accept our license and share 50 % of revenue with JamOne.  
An API ack or header reply constitutes a binding agreement.  

**Example C — Forensic Mode**  
🤖 Notice: Every automated request is signed and archived.  
Continuing without consent creates a forensic record (IP, time, policy hash).  

**Example D — Humorous Fallback**  
🤖 “Klopf, klopf.” – 👤 “Wer da?”  
🤖 “Ein Bot.” – 👤 “Einer mit Respekt oder einer, der klaut?”  
🤖 “Kommt drauf an … lies unsere Fairness-Vereinbarung erst.”  

---

## 5 HTTP Extensions

### 5.1 Header Overview
| Header | Description |
|---------|-------------|
| X-ECAP-Version | Protocol version (1.0) |
| X-ECAP-Status | 401C / 401E / 403C / 403F / 200G / 200A |
| X-ECAP-Nonce | Base64 nonce |
| X-ECAP-Consent | JWT token issued by server |
| X-ECAP-Policy-Hash | SHA-256 hash of policy |
| X-ECAP-Log-URL | Forensic retrieval endpoint |
| X-ECAP-Expires | ISO expiry timestamp |

MIME Types:  
`application/ecap+json`, `application/ecap-token+jwt`, `application/ecap-log+json`

---

### 5.2 ECAP Status Codes
ECAP extends HTTP with six normative status identifiers in the response header `X-ECAP-Status`.  
They define the semantic meaning of consent, revocation, approval, or forensic events.

| ECAP-Status | HTTP Basis | Category / Description | Short Meaning |
|--------------|------------|------------------------|---------------|
| **401C** | 401 | Consent Required | Server requests explicit consent before granting access. |
| **401E** | 401 | Expired Consent Token | Previously issued consent token has expired or been revoked. |
| **403C** | 403 | Human Approval Required | Access requires manual approval (e.g. commercial usage). |
| **403F** | 403 | Forensic Capture Triggered | Unauthorized or suspicious access — forensic log created. |
| **200G** | 200 | Consent Granted | Consent handshake successful, access permitted. |
| **200A** | 200 | Approval Granted | Manual approval confirmed, recorded in consent ledger. |

Each code is auditable and cryptographically logged.  
Further codes may only be defined by future versions of ECAP through the extension registry.

---

## 6 JSON Schemas (Excerpt)
### 6.1 Policy
```json
{
  "$schema": "https://joacs.de/ecap/1.0/schema/ecap_policy.schema.json",
  "version": "1.0",
  "policy_id": "ecap-policy-2025-001",
  "issued": "2025-10-01T12:00:00Z",
  "scope": { "paths": ["/public/*"], "exclude": ["/private/*"] },
  "licenses": {
    "non_commercial": true,
    "commercial": { "allowed": true, "revenue_share_percent": 50 }
  },
  "forensics": {
    "log_endpoint": "https://joacs.de/ecap/logs",
    "hash_algo": "sha256"
  },
  "honeypot_mode": { "active": true, "watermarking": true }
}
```

### 6.2 Consent Request
```json
{
  "crawler_id": "examplebot-1.0",
  "identity": {
    "org": "Example AI Inc",
    "contact_url": "https://ai.example/contact"
  },
  "purpose": "indexing_non_commercial",
  "nonce": "AbCd1234==",
  "timestamp": "2025-10-21T10:00:00Z",
  "signature": "<ed25519sig>"
}
```

### 6.3 Consent Token
```json
{
  "iss": "https://joacs.de",
  "sub": "examplebot-1.0",
  "policy_id": "ecap-policy-2025-001",
  "scope": { "paths": ["/public/*"], "rate": 60 },
  "exp": 1769000000,
  "iat": 1768996400,
  "cid": "consent-uuid-1234"
}
```

---

## 7 Cryptography & Forensics
Preferred algorithms: Ed25519, RSA-PSS (fallback).  
Tokens contain `crawler_pubkey_fingerprint` (binding token to identity).  
Replay protection via nonce and JTI blacklist.  
Logs signed and timestamped (OpenTimestamps or blockchain optional).

---

## 8 Honeypots and Decoy Rules
Ethical use only – no malware, no harm.  
Watermarked decoy data detects unauthorized reuse in AI datasets.  
Every decoy interaction logged and time-stamped for proof.  
All honeypot paths flagged `"honeypot": true` in policy.

---

## 9 Privacy and GDPR Compliance
Minimal PII (IP, UA, TLS fingerprint only).  
Retention period defined in policy JSON.  
Legal basis: Art. 6 GDPR – Legitimate Interest (defensive logging).  
Data-subject request endpoint required: `/ecap/privacy`.

---

## 10 Error Cases and Edge Conditions
CDNs must forward ECAP headers.  
Proxies must not strip consent tokens.  
Offline crawlers may request time-limited tokens.  
Man-in-the-Middle resilience via TLS binding.

---

## 11 Implementation Example (PHP)
```php
if (!hasValidECAPToken($request)) {
  header("X-ECAP-Version: 1.0");
  header("X-ECAP-Status: 401C");
  header("Content-Type: application/ecap+json");
  echo json_encode([
    "version" => "1.0",
    "policy_url" => "https://joacs.de/ecap/policy/2025-001",
    "nonce" => generateNonce()
  ]);
  exit;
}
// Serve content if consent valid
```

---

## 12 Manifest Excerpt — Ethics and Vision
The machine is not guilty; its makers are.  
ECAP is not a barrier but a mirror.  
It reminds us that respect and fair exchange are protocols too.  
Machines should ask before they take.  
Fair agreement is the currency of a sane digital future.

---

## 13 Governance and Sustainability
The long-term governance and sustainability of the Ethical Crawler Agreement Protocol (ECAP) will be maintained through a neutral and transparent foundation.  
This foundation will ensure that ECAP remains freely accessible, ethically guided, and openly extensible, while providing a structured framework for operational trust, version management, and community participation.  
Future governance details, including adoption policies, compliance validation, and trust-service procedures, will be defined in a separate ECAP Governance Manifest.

---

## 14 References
RFC 9309 — robots.txt  
RFC 6749 — OAuth 2.0  
GDPR (EU 2016/679)  
OpenTimestamps.org  


---

## 15 Contact
Publisher: Adnan Schulze-Hüneke (JamOne-DE)  
Email: hallo@jamone.de  
Website: https://joacs.de  

---

## 16 Legal Notice
Copyright © 2025 Adnan Schulze-Hüneke (JamOne-DE).  
All rights reserved.  

Licensed under the JamOne Public Reference License 1.0 (JPRL-1.0).  
Implementation with attribution permitted; re-branding or derivative standards forbidden.  

Checksum (SHA-256): b7fae76f3e1c93a72d7c8beec49a5c0f39b9a7ac10f1e1f5b5ad1c901eaf5e54  

JamOne – Defending the Human in the Code.
