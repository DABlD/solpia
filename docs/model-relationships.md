# Model Relationships

This diagram is based on the Eloquent relationship methods in `app/Models`.
It favors the domain model links declared in code over database-only naming assumptions.

```mermaid
flowchart LR
    %% Core applicant profile
    User["App\\User"]
    Applicant["Applicant"]
    EducationalBackground["EducationalBackground"]
    FamilyData["FamilyData"]
    SeaService["SeaService"]
    Evaluation["Evaluation"]

    Applicant -->|"belongsTo user()"| User
    Applicant -->|"hasMany educational_background()"| EducationalBackground
    Applicant -->|"hasMany family_data()"| FamilyData
    Applicant -->|"hasMany sea_service()"| SeaService
    Applicant -->|"hasMany evaluation()"| Evaluation
    SeaService -->|"belongsTo applicant()"| Applicant

    %% Applicant documents
    DocumentId["DocumentId"]
    DocumentFlag["DocumentFlag"]
    DocumentLC["DocumentLC"]
    DocumentMed["DocumentMed"]
    DocumentMedExp["DocumentMedExp"]
    DocumentMedCert["DocumentMedCert"]
    Rank["Rank"]

    Applicant -->|"hasMany document_id()"| DocumentId
    Applicant -->|"hasMany document_flag()"| DocumentFlag
    Applicant -->|"hasMany document_lc()"| DocumentLC
    Applicant -->|"hasMany document_med()"| DocumentMed
    Applicant -->|"hasMany document_med_exp()"| DocumentMedExp
    Applicant -->|"hasMany document_med_cert()"| DocumentMedCert
    DocumentId -->|"belongsTo applicant()"| Applicant
    DocumentFlag -->|"belongsTo rankz()"| Rank
    DocumentLC -->|"belongsTo rank2()"| Rank

    %% Crewing and line-up
    ProcessedApplicant["ProcessedApplicant"]
    Principal["Principal"]
    Vessel["Vessel"]
    Wage["Wage"]
    LineUpContract["LineUpContract"]

    Applicant -->|"hasOne pro_app()"| ProcessedApplicant
    ProcessedApplicant -->|"belongsTo applicant()"| Applicant
    ProcessedApplicant -->|"belongsTo principal()"| Principal
    ProcessedApplicant -->|"belongsTo vessel()"| Vessel
    ProcessedApplicant -->|"belongsTo rank()"| Rank
    ProcessedApplicant -->|"hasOne wage()"| Wage

    Applicant -->|"hasMany line_up_contracts()"| LineUpContract
    Applicant -->|"hasOne current_lineup()"| LineUpContract
    LineUpContract -->|"belongsTo applicant()"| Applicant
    LineUpContract -->|"hasOne vessel()"| Vessel
    LineUpContract -->|"hasOne rank()"| Rank
    LineUpContract -->|"hasOne pa_reliever()"| ProcessedApplicant
    LineUpContract -->|"hasMany document_id()"| DocumentId
    LineUpContract -->|"hasMany document_flag()"| DocumentFlag
    LineUpContract -->|"hasMany document_lc()"| DocumentLC
    LineUpContract -->|"hasMany document_med_cert()"| DocumentMedCert

    Principal -->|"belongsTo user()"| User
    Vessel -->|"belongsTo principal()"| Principal
    SeaService -->|"hasOne vessel2()"| Vessel
    SeaService -->|"hasMany vessel()"| Vessel
    SeaService -->|"hasOne rank2()"| Rank

    %% Recruitment pipeline
    Requirement["Requirement"]
    Candidate["Candidate"]
    Prospect["Prospect"]

    Requirement -->|"belongsTo user()"| User
    Requirement -->|"hasOne vessel()"| Vessel
    Requirement -->|"hasOne rank()/rank2()"| Rank
    Requirement -->|"hasMany candidates()"| Candidate
    Candidate -->|"hasOne requirement()"| Requirement
    Candidate -->|"hasOne applicant()"| Applicant
    Candidate -->|"hasOne prospect()"| Prospect
    Candidate -->|"hasOne vessel()"| Vessel
    Prospect -->|"hasMany candidates()"| Candidate

    %% Temporary application flow
    TempUser["App\\TempUser"]
    TempApplicant["TempApplicant"]
    TempSeaService["TempSeaService"]

    TempApplicant -->|"belongsTo temp user()"| TempUser
    TempApplicant -->|"hasMany temp sea services()"| TempSeaService
    TempSeaService -->|"belongsTo temp applicant()"| TempApplicant

    %% Appointments
    Appointment["Appointment"]
    Appointment -->|"hasOne user()"| User
```

## Isolated Or Undeclared

These models exist in `app/Models`, but no relationship method was found in the model search:

- `AuditTrail`
- `ExportLogs`
- `File`
- `Interview`
- `Opening`
- `Role`
- `Ssap`
- `Statistic`

## Notes

- `LineUpContract` uses applicant-level document relationships by matching `applicant_id` to its own `applicant_id`.
- Some relationships named as `hasOne` are lookup-style links where the current model stores the foreign key, such as `Candidate -> Requirement`, `Candidate -> Applicant`, and `Requirement -> Vessel`.
- `ProcessedApplicant::wage()` matches on `vessel_id` and also filters by the current `rank_id`.
