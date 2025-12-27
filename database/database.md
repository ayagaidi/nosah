 Database Structure and Relationships

This document provides a detailed explanation of the database schema, relationships, and fields for the healthcare management system.

---

 Tables and Relationships

 1. Users Table (`users`)
- Fields:
  - `id`: Primary key.
  - `first_name`, `last_name`: User's name.
  - `username`, `email`: Unique identifiers.
  - `phonenumber`: Unique phone number.
  - `email_verified_at`: Timestamp for email verification.
  - `password`: User's password.
  - `active`: Boolean to indicate if the user is active.
  - `created_at`: Timestamp for user creation.
  - `cities_id`: Foreign key referencing the `cities` table.
  - `user_type_id`: Foreign key referencing the `user_types` table.

- Relationships:
  - Belongs to `cities` and `user_types`.

---

 2. Doctors Table (`doctors`)
- Fields:
  - `id`: Primary key.
  - `fullname`, `username`, `email`: Doctor's details.
  - `phonenumber`: Unique phone number.
  - `email_verified_at`: Timestamp for email verification.
  - `password`: Doctor's password.
  - `active`: Boolean to indicate if the doctor is active.
  - `image`, `cv`: Optional fields for doctor's image and CV.
  - `created_at`: Timestamp for doctor creation.
  - `specializations_id`: Foreign key referencing the `specializations` table.

- Relationships:
  - Belongs to `specializations`.

---

 3. Patients Table (`patients`)
- Fields:
  - `id`: Primary key.
  - `doctors_id`: Foreign key referencing the `doctors` table.
  - `patient_number`: Unique identifier for the patient.
  - `full_name`, `email`, `password`: Patient's details.
  - `dob`: Date of birth.
  - `gender`: Enum for gender (`M` or `F`).
  - `address`, `contact_number`: Patient's contact details.
  - `medical_history`, `allergies`, `medications`: Medical information.
  - `active`: Boolean to indicate if the patient is active.
  - `created_at`: Timestamp for patient creation.

- Relationships:
  - Belongs to `doctors`.

---

 4. Appointments Table (`appointments`)
- Fields:
  - `id`: Primary key.
  - `patient_id`, `doctor_id`, `clinic_id`: Foreign keys referencing `patients`, `doctors`, and `clinics` tables.
  - `scheduled_at`: Date and time of the appointment.
  - `status`: Enum for appointment status (`scheduled`, `rescheduled`, `cancelled`, `completed`).
  - `rescheduled_at`, `reschedule_reason`: Details for rescheduling.
  - `location`: Optional location for the appointment.
  - `appointment_type`: Enum for appointment type (`كشف`, `مراجعة`, `استشارة`, `مجاني`).
  - `created_by`, `updated_by`: User IDs for tracking changes.
  - `notes`: Additional notes.
  - `attendance_status`: Enum for attendance status (`present`, `absent`).

- Relationships:
  - Belongs to `patients`, `doctors`, and `clinics`.

---

 5. Clinics Table (`clinics`)
- Fields:
  - `id`: Primary key.
  - `name`, `address`, `phone_number`: Clinic details.
  - `url_location`: Optional URL for the clinic's location.
  - `created_at`: Timestamp for clinic creation.
  - `active`: Boolean to indicate if the clinic is active.
  - `cities_id`: Foreign key referencing the `cities` table.

- Relationships:
  - Belongs to `cities`.

---

 6. Specializations Table (`specializations`)
- Fields:
  - `id`: Primary key.
  - `name`: Name of the specialization.
  - `created_at`: Timestamp for specialization creation.
  - `active`: Boolean to indicate if the specialization is active.

---

 7. Patient Files Table (`patient_files`)
- Fields:
  - `id`: Primary key.
  - `patient_id`: Foreign key referencing the `patients` table.
  - `title`: Title of the file.
  - `file_path`: Path to the file.
  - `created_at`, `updated_at`: Timestamps for file creation and updates.

- Relationships:
  - Belongs to `patients`.

---

 8. Patient Diet Plans Table (`patient_diet_plans`)
- Fields:
  - `id`: Primary key.
  - `patient_id`: Foreign key referencing the `patients` table.
  - `date`: Date of the diet plan.
  - `meal_type`, `food_category`, `food_item`: Details of the diet plan.
  - `portion_size`, `calories`, `carbs`, `protein`, `fat`, `fiber`: Nutritional information.
  - `fluid_intake`, `supplements`: Additional dietary details.
  - `special_instructions`, `dietary_restrictions`, `compliance_notes`: Notes for the diet plan.
  - `prescribed_by`: ID of the doctor who prescribed the diet plan.
  - `date_prescribed`: Date the diet plan was prescribed.
  - `created_at`, `updated_at`: Timestamps for diet plan creation and updates.

- Relationships:
  - Belongs to `patients`.

---

 9. Diets Table (`diets`)
- Fields:
  - `id`: Primary key.
  - `title`: Title of the diet.
  - `text`: Description of the diet.
  - `image`: Optional image for the diet.
  - `published`: Boolean to indicate if the diet is published.
  - `created_at`, `updated_at`: Timestamps for diet creation and updates.

---

 10. Chat Messages Table (`chat_messages`)
- Fields:
  - `id`: Primary key.
  - `sender_id`, `sender_type`: ID and type of the sender (`doctor` or `patient`).
  - `receiver_id`, `receiver_type`: ID and type of the receiver (`doctor` or `patient`).
  - `message`: Content of the message.
  - `is_read`: Boolean to indicate if the message has been read.
  - `created_at`, `updated_at`: Timestamps for message creation and updates.

---

 11. Contact Infos Table (`contactinfos`)
- Fields:
  - `id`: Primary key.
  - `phonenumber`, `email`: Contact details.
  - `created_at`, `updated_at`: Timestamps for contact info creation and updates.

---

 Summary of Relationships

- Users belong to Cities and User Types.
- Doctors belong to Specializations.
- Patients belong to Doctors.
- Appointments belong to Patients, Doctors, and Clinics.
- Clinics belong to Cities.
- Patient Files belong to Patients.
- Patient Diet Plans belong to Patients.
- Chat Messages are sent between Doctors and Patients.

---

This structure supports a comprehensive healthcare management system with relationships between doctors, patients, clinics, appointments, and more.

---

 شرح قاعدة البيانات والعلاقات

هذا المستند يوفر شرحًا مفصلاً لهيكلة قاعدة البيانات والعلاقات والحقول لنظام إدارة الرعاية الصحية.

---

 الجداول والعلاقات

 1. جدول المستخدمين (`users`)
- الحقول:
  - `id`: المفتاح الرئيسي.
  - `first_name`, `last_name`: اسم المستخدم.
  - `username`, `email`: معرفات فريدة.
  - `phonenumber`: رقم الهاتف الفريد.
  - `email_verified_at`: طابع زمني للتحقق من البريد الإلكتروني.
  - `password`: كلمة مرور المستخدم.
  - `active`: قيمة منطقية تشير إلى ما إذا كان المستخدم نشطًا.
  - `created_at`: طابع زمني لإنشاء المستخدم.
  - `cities_id`: مفتاح خارجي يشير إلى جدول `cities`.
  - `user_type_id`: مفتاح خارجي يشير إلى جدول `user_types`.

- العلاقات:
  - ينتمي إلى `cities` و `user_types`.

---

 2. جدول الأطباء (`doctors`)
- الحقول:
  - `id`: المفتاح الرئيسي.
  - `fullname`, `username`, `email`: تفاصيل الطبيب.
  - `phonenumber`: رقم الهاتف الفريد.
  - `email_verified_at`: طابع زمني للتحقق من البريد الإلكتروني.
  - `password`: كلمة مرور الطبيب.
  - `active`: قيمة منطقية تشير إلى ما إذا كان الطبيب نشطًا.
  - `image`, `cv`: حقول اختيارية لصورة الطبيب والسيرة الذاتية.
  - `created_at`: طابع زمني لإنشاء الطبيب.
  - `specializations_id`: مفتاح خارجي يشير إلى جدول `specializations`.

- العلاقات:
  - ينتمي إلى `specializations`.

---

 3. جدول المرضى (`patients`)
- الحقول:
  - `id`: المفتاح الرئيسي.
  - `doctors_id`: مفتاح خارجي يشير إلى جدول `doctors`.
  - `patient_number`: معرف فريد للمريض.
  - `full_name`, `email`, `password`: تفاصيل المريض.
  - `dob`: تاريخ الميلاد.
  - `gender`: تعداد لنوع الجنس (`M` أو `F`).
  - `address`, `contact_number`: تفاصيل الاتصال بالمريض.
  - `medical_history`, `allergies`, `medications`: معلومات طبية.
  - `active`: قيمة منطقية تشير إلى ما إذا كان المريض نشطًا.
  - `created_at`: طابع زمني لإنشاء المريض.

- العلاقات:
  - ينتمي إلى `doctors`.

---

 4. جدول المواعيد (`appointments`)
- الحقول:
  - `id`: المفتاح الرئيسي.
  - `patient_id`, `doctor_id`, `clinic_id`: مفاتيح خارجية تشير إلى جداول `patients` و `doctors` و `clinics`.
  - `scheduled_at`: تاريخ ووقت الموعد.
  - `status`: تعداد لحالة الموعد (`scheduled`, `rescheduled`, `cancelled`, `completed`).
  - `rescheduled_at`, `reschedule_reason`: تفاصيل لإعادة الجدولة.
  - `location`: موقع اختياري للموعد.
  - `appointment_type`: تعداد لنوع الموعد (`كشف`, `مراجعة`, `استشارة`, `مجاني`).
  - `created_by`, `updated_by`: معرفات المستخدمين لتتبع التغييرات.
  - `notes`: ملاحظات إضافية.
  - `attendance_status`: تعداد لحالة الحضور (`present`, `absent`).

- العلاقات:
  - ينتمي إلى `patients` و `doctors` و `clinics`.

---

 5. جدول العيادات (`clinics`)
- الحقول:
  - `id`: المفتاح الرئيسي.
  - `name`, `address`, `phone_number`: تفاصيل العيادة.
  - `url_location`: عنوان URL اختياري لموقع العيادة.
  - `created_at`: طابع زمني لإنشاء العيادة.
  - `active`: قيمة منطقية تشير إلى ما إذا كانت العيادة نشطة.
  - `cities_id`: مفتاح خارجي يشير إلى جدول `cities`.

- العلاقات:
  - ينتمي إلى `cities`.

---

 6. جدول التخصصات (`specializations`)
- الحقول:
  - `id`: المفتاح الرئيسي.
  - `name`: اسم التخصص.
  - `created_at`: طابع زمني لإنشاء التخصص.
  - `active`: قيمة منطقية تشير إلى ما إذا كان التخصص نشطًا.

---

 7. جدول ملفات المرضى (`patient_files`)
- الحقول:
  - `id`: المفتاح الرئيسي.
  - `patient_id`: مفتاح خارجي يشير إلى جدول `patients`.
  - `title`: عنوان الملف.
  - `file_path`: مسار الملف.
  - `created_at`, `updated_at`: طوابع زمنية لإنشاء الملف وتحديثه.

- العلاقات:
  - ينتمي إلى `patients`.

---

 8. جدول خطط النظام الغذائي للمرضى (`patient_diet_plans`)
- الحقول:
  - `id`: المفتاح الرئيسي.
  - `patient_id`: مفتاح خارجي يشير إلى جدول `patients`.
  - `date`: تاريخ خطة النظام الغذائي.
  - `meal_type`, `food_category`, `food_item`: تفاصيل خطة النظام الغذائي.
  - `portion_size`, `calories`, `carbs`, `protein`, `fat`, `fiber`: معلومات غذائية.
  - `fluid_intake`, `supplements`: تفاصيل غذائية إضافية.
  - `special_instructions`, `dietary_restrictions`, `compliance_notes`: ملاحظات لخطة النظام الغذائي.
  - `prescribed_by`: معرف الطبيب الذي وصف خطة النظام الغذائي.
  - `date_prescribed`: تاريخ وصف خطة النظام الغذائي.
  - `created_at`, `updated_at`: طوابع زمنية لإنشاء خطة النظام الغذائي وتحديثها.

- العلاقات:
  - ينتمي إلى `patients`.

---

 9. جدول الأنظمة الغذائية (`diets`)
- الحقول:
  - `id`: المفتاح الرئيسي.
  - `title`: عنوان النظام الغذائي.
  - `text`: وصف النظام الغذائي.
  - `image`: صورة اختيارية للنظام الغذائي.
  - `published`: قيمة منطقية تشير إلى ما إذا كان النظام الغذائي منشورًا.
  - `created_at`, `updated_at`: طوابع زمنية لإنشاء النظام الغذائي وتحديثه.

---

 10. جدول رسائل الدردشة (`chat_messages`)
- الحقول:
  - `id`: المفتاح الرئيسي.
  - `sender_id`, `sender_type`: معرف ونوع المرسل (`doctor` أو `patient`).
  - `receiver_id`, `receiver_type`: معرف ونوع المستلم (`doctor` أو `patient`).
  - `message`: محتوى الرسالة.
  - `is_read`: قيمة منطقية تشير إلى ما إذا كانت الرسالة قد تم قراءتها.
  - `created_at`, `updated_at`: طوابع زمنية لإنشاء الرسالة وتحديثها.

---

 11. جدول معلومات الاتصال (`contactinfos`)
- الحقول:
  - `id`: المفتاح الرئيسي.
  - `phonenumber`, `email`: تفاصيل الاتصال.
  - `created_at`, `updated_at`: طوابع زمنية لإنشاء معلومات الاتصال وتحديثها.

---

 ملخص العلاقات

- المستخدمون ينتمون إلى المدن و أنواع المستخدمين.
- الأطباء ينتمون إلى التخصصات.
- المرضى ينتمون إلى الأطباء.
- المواعيد تنتمي إلى المرضى و الأطباء و العيادات.
- العيادات تنتمي إلى المدن.
- ملفات المرضى تنتمي إلى المرضى.
- خطط النظام الغذائي للمرضى تنتمي إلى المرضى.
- رسائل الدردشة ترسل بين الأطباء و المرضى.

---

هذه الهيكل يدعم نظام إدارة الرعاية الصحية الشامل مع العلاقات بين الأطباء والمرضى والعيادات والمواعيد والمزيد.