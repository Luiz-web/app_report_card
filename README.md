
<h1> APP Report Card</12>

<h2>About the Project</h2>
<p>This project is developed with PHP, Laravel with the MySQL database. It consists of a school report API REST that indicates which students are approved, with the objective of organizing groups of students by professional focus who have been approved to participate in events related to the desired professional area at the time of enrollment or through an update along the year </p>

<p>The system use relationships between tables, so according to a data inserted in one table, in another table this data may be present with adictional information added dynamically through the processing conditions in the system.</p>
<br/>

<h2>Tables</h2>
<h3><i>students</i></h3>
<p>The students table can be considered the base table in the project, which de data related to enrollment and student perfomance throughout the year are inserted. These data are:</p>
<ul>
    <li>name</li>
    <li>age</li>
    <li>school_year-id (that is related to the school years table, which have the school years as "First Year", "Second Year", "Third Year")</li>
    <li> professional_focus_id(that is related to the professional_focus table, which have the professional areas as "Technology", "Medicine", "Engineer", etc)</li>
    <li>first_score</li>
    <li>second_score</li>
</ul>

<h3><i>school_years</i></h3>
<p>This table has the school years name, as "First Year" and others.</p>

<h3><i>professional_focus</i></h3>
<p>This table has the professinal areas name, as "Technology", "Engineer" and others.</p>

<h3><i>situations</i></h3>
<p>The student_id is the only data that is inserted by the client in this table, through it(once the student is already in the students table), the system will process dynamically the others data related to the situations'table, which are:</p>
<ul>
    <li>total_score(sum of first_score and second_score from students table)</li>
    <li>status(This return whether the student is approved or not, with "A" being approved and "R" being reproved)</li>
    <li>name(student's name in students table)</li>
</ul>

<h3><i>approved</i></h3>
<p>This is the approved table, which it have all the students that have an "A" status in the situation table. This table doesn't need to insert any data, since the Eloquent ORM does the process of verification and populate this table, whenever the store method of Approved is called, it's checked if the situations table has a new approved student inserted.</p>

<br/>
<h2>Authentication</h2>
<p>This API uses authentication through the <a href="https://github.com/tymondesigns/jwt-auth">JWT Auth (Json Web Token)</a>, To access certain routes and functions, it's necessary that the registered users(being a professional from the educational institution) are authenticated with a valid token.</p>


