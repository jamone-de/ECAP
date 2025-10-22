[![DOI](https://zenodo.org/badge/DOI/10.5281/zenodo.17420277.svg)](https://doi.org/10.5281/zenodo.17420277)

# ECAP / 1.0 — Ethical Crawler Agreement Protocol  
*A Human-First Standard for Responsible Automation*  
Version 1.0 · Public Reference Specification · October 2025  

---

## 🌍 Overview
The **Ethical Crawler Agreement Protocol (ECAP)** defines a transparent, auditable, and privacy-aware handshake between automated systems and websites.  
It restores the lost digital handshake once represented by `robots.txt` — replacing blind extraction with verifiable, consent-based access.  

ECAP introduces a new ethical layer for automated data exchange:  
websites can publish clear usage policies, and automated agents (e.g., crawlers, AI indexers) must request and obtain cryptographically signed consent tokens before accessing protected data.

This ensures that every automated interaction on the web can be **transparent**, **accountable**, and **privacy-respecting**.

---

## ⚙️ Core Principles
- **Transparency** — Websites declare clear and machine-readable access policies.  
- **Accountability** — Consent interactions are digitally signed and verifiable.  
- **Simplicity** — Lightweight HTTP extension; fully backwards-compatible.  
- **Fairness** — Supports non-commercial and licensed commercial use cases.  
- **Privacy by Design** — Collects only minimal, lawful forensic metadata.  

---

## 📘 Specification
The complete public reference specification is available here:  
➡️ [`/1.0/ECAP_1_0_Specification.md`](1.0/ECAP_1_0_Specification.md)

Additional reference documents:
- [`/1.0/ECAP_1_0_Manifest.md`](1.0/ECAP_1_0_Manifest.md)
- [`/1.0/ECAP_1_0_StatusCodes.md`](1.0/ECAP_1_0_StatusCodes.md)
- [`/1.0/ECAP_1_0_Policy.json`](1.0/ECAP_1_0_Policy.json)
- [`/1.0/verify/verify.json`](1.0/verify/verify.json)

---

## 🧩 Implementation Structure
| Component | Description |
|------------|-------------|
| `/1.0/ECAP_1_0_Specification.md` | Full reference specification (RFC-style) |
| `/1.0/ECAP_1_0_Manifest.md` | Machine-readable metadata manifest |
| `/1.0/ECAP_1_0_StatusCodes.md` | Status & verification codes |
| `/1.0/ECAP_1_0_Policy.json` | Policy definition template |
| `/1.0/GDPR_COMPLIANCE.md` | Data protection & privacy statement |
| `/1.0/LEGAL_NOTICE.md` | Legal and attribution notice |
| `/1.0/LICENSE_JPRL_1_0.txt` | License copy for reference |
| `/1.0/verify/verify.json` | Public verification endpoint |
| `/1.0/assets/logo_ecap.svg` | Official ECAP seal |

---

## 🔐 Verification
**Verify authenticity and checksum:**  
[https://joacs.de/ecap/1.0/verify/verify.json](https://joacs.de/ecap/1.0/verify/verify.json)

**Checksum (SHA-256):**  
`783CD00F6298B754AF2CB53D010074A92C99E024AA8BEAA74757BF1AD06B9FFD`

---

## ⚖️ Legal and Licensing
This work is published under the  
**JamOne Public Reference License (JPRL-1.0)** —  
allowing free use for study, implementation, and ethical interoperability **with proper attribution**.  

Re-branding, derivative standards, or commercial resale are strictly prohibited.  

> © 2025 Adnan Schulze-Hüneke (JamOne-DE).  
> All rights reserved.  
> Licensed under JPRL-1.0 — reuse permitted with attribution.

---

## 🧠 Citation
If you reference ECAP in research or publications:

```
Schulze-Hüneke, Adnan (2025). 
ECAP / 1.0 — Ethical Crawler Agreement Protocol.
JamOne-DE. https://joacs.de/ecap/1.0/
```

A DOI will be registered via Zenodo (planned for version 1.1).

---

## 📬 Contact
**Publisher:** JamOne-DE (Adnan Schulze-Hüneke)  
**Email:** [hallo@jamone.de](mailto:hallo@jamone.de)  
**Website:** [https://joacs.de](https://joacs.de)  
**Project:** [https://github.com/jamone-de/ecap](https://github.com/jamone-de/ecap)

---

### 🜲 JamOne — Defending the Human in the Code.
