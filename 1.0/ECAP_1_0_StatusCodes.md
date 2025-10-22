\# ECAP / 1.0  

\## Status Code Reference (X-ECAP-Status)



\*\*Version:\*\* 1.0  

\*\*Date:\*\* 2025-10-21  

\*\*Publisher:\*\* Adnan Schulze-Hüneke (JamOne-DE)  

\*\*License:\*\* JPRL-1.0  

\*\*File:\*\* `ECAP\_1\_0\_StatusCodes.md`  



---



\### 🔍 Purpose



This document defines the standardized \*\*ECAP status codes\*\* (HTTP header field `X-ECAP-Status`) for the  

\*\*Ethical Crawler Agreement Protocol / 1.0\*\*.  



The codes extend classical HTTP semantics and enable automated agents and auditors  

to interpret \*\*crawler/server handshakes\*\*, \*\*consent states\*\*, and \*\*forensic events\*\* precisely.  



Each status code is unique, versioned, and interoperable with existing HTTP infrastructures.



---



\## 🧭 1 – Overview



| ECAP Status | HTTP Base | Category / Meaning | Short Description |

|--------------|-----------|--------------------|-------------------|

| \*\*401C\*\* | 401 | Consent Required | The server requests an ECAP consent declaration before access. |

| \*\*401E\*\* | 401 | Expired Consent Token | The provided consent token has expired or been revoked. |

| \*\*403C\*\* | 403 | Human Approval Required | Access requires manual approval (e.g. commercial use). |

| \*\*403F\*\* | 403 | Forensic Capture Triggered | Unauthorized access — forensic logging activated. |

| \*\*200G\*\* | 200 | Consent Granted | Access granted — consent handshake completed successfully. |

| \*\*200A\*\* | 200 | Approval Granted | Human approval completed and recorded in the ledger. |



---



\## 🧩 2 – Definitions



\### \*\*401C — Consent Required\*\*

\- \*\*Description:\*\* The requested resource is protected by an ECAP policy.  

&nbsp; The crawler must initiate a signed consent request.  

\- \*\*Required Headers:\*\*  

&nbsp; - `X-ECAP-Version: 1.0`  

&nbsp; - `X-ECAP-Status: 401C`  

\- \*\*Example Response Body:\*\*

&nbsp; ```json

&nbsp; {

&nbsp;   "policy\_url": "https://example.org/ecap/1.0/ECAP\_1\_0\_Policy.json",

&nbsp;   "nonce": "base64url\_nonce"

&nbsp; }

&nbsp; ```

\- \*\*Next Action:\*\* Crawler POSTs to `/ecap/consent`.



---



\### \*\*401E — Expired Consent Token\*\*

\- \*\*Description:\*\* The attached consent token is no longer valid.  

\- \*\*Required Header:\*\* `X-ECAP-Status: 401E`  

\- \*\*Example Response Body:\*\*

&nbsp; ```json

&nbsp; {

&nbsp;   "message": "Token expired — please renew consent via /ecap/consent",

&nbsp;   "revocation\_reason": "expiry",

&nbsp;   "revoked\_at": "2025-10-22T00:00:00Z"

&nbsp; }

&nbsp; ```

\- \*\*Next Action:\*\* Renew consent handshake.



---



\### \*\*403C — Human Approval Required\*\*

\- \*\*Description:\*\* The requested resource requires manual approval (e.g. for commercial usage or sensitive data).  

\- \*\*Required Header:\*\* `X-ECAP-Status: 403C`  

\- \*\*Example Response Body:\*\*

&nbsp; ```json

&nbsp; {

&nbsp;   "follow\_up": "interactive",

&nbsp;   "approval\_url": "https://joacs.de/ecap/approval?id=AB12"

&nbsp; }

&nbsp; ```

\- \*\*Next Action:\*\* User visits `approval\_url` and confirms conditions.  

\- \*\*Ledger Note:\*\* Approval is cryptographically stored in the consent ledger.



---



\### \*\*403F — Forensic Capture Triggered\*\*

\- \*\*Description:\*\* Server detected unauthorized or suspicious behavior.  

&nbsp; A forensic log entry (IP, User-Agent, timestamp, hash, signature) is created.  

\- \*\*Required Header:\*\* `X-ECAP-Status: 403F`  

\- \*\*Example Response Body:\*\*

&nbsp; ```json

&nbsp; {

&nbsp;   "message": "Forensic record created",

&nbsp;   "log\_id": "ecap-log-2025-00023"

&nbsp; }

&nbsp; ```

\- \*\*Security Note:\*\* Entries must be digitally signed (`signature\_server`).  

\- \*\*Purpose:\*\* Transparent traceability of unauthorized automated access.



---



\### \*\*200G — Consent Granted\*\*

\- \*\*Description:\*\* Consent handshake successful.  

\- \*\*Required Headers:\*\*  

&nbsp; - `X-ECAP-Status: 200G`  

&nbsp; - `X-ECAP-Consent` (JWT token)  

&nbsp; - `X-ECAP-Policy-Hash` (Base64url-SHA256)  

\- \*\*Example Response Body:\*\*

&nbsp; ```json

&nbsp; {

&nbsp;   "message": "Consent granted",

&nbsp;   "expires": "2025-10-22T00:00:00Z"

&nbsp; }

&nbsp; ```

\- \*\*Next Action:\*\* Crawler may access resources as defined by the policy.



---



\### \*\*200A — Approval Granted\*\*

\- \*\*Description:\*\* Manual approval completed and digitally signed.  

\- \*\*Required Header:\*\* `X-ECAP-Status: 200A`  

\- \*\*Example Response Body:\*\*

&nbsp; ```json

&nbsp; {

&nbsp;   "message": "Consent approved and logged",

&nbsp;   "token": "jwt\_token\_approved",

&nbsp;   "policy\_hash": "sha256:..."

&nbsp; }

&nbsp; ```

\- \*\*Ledger Entry:\*\* Approval recorded with `proof\_reference` and `policy\_hash`.



---



\## 🔐 3 – Implementation Notes



\- Header values are \*\*case-sensitive\*\*.  

\- All timestamps use \*\*UTC ISO-8601 (Z suffix)\*\*.  

\- Hash values are \*\*Base64url-encoded (SHA-256 or stronger)\*\*.  

\- `X-ECAP-Status` may co-exist with standard HTTP codes, e.g.:  

&nbsp; ```

&nbsp; HTTP/1.1 401 Unauthorized

&nbsp; X-ECAP-Status: 401C

&nbsp; ```



---



\## 🧾 4 – Version History



| Version | Date | Change | Responsible |

|----------|------|---------|-------------|

| 1.0 | 2025-10-21 | Initial release | Adnan Schulze-Hüneke (JamOne-DE) |



---



\*\*End of File\*\*  

`ECAP\_1\_0\_StatusCodes.md`  

\*Reference document for the Ethical Crawler Agreement Protocol / Version 1.0.\*



