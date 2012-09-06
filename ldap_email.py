# -*- coding: utf-8 -*-

import ldap
import MySQLdb
import unicodedata
import string

def find_adherent(debut):
    l = ldap.open('157.159.10.22')
    l.simple_bind()
    s = l.search('', ldap.SCOPE_SUBTREE, 'sn='+debut.upper(), None)
    r = l.result(s)
    if len(r[1]) != 1:
        return False
    else:
        return (r[1][0][1]['mail'][0], r[1][0][1]['uid'][0])

db = MySQLdb.connect(host='localhost', user='toto', \
    passwd='toto', db='toto')
c = db.cursor()
c.execute("SELECT * from adherent LEFT JOIN profil ON profil.adherent_id = adherent.id WHERE email != ''")
erreurs = []
for i in c.fetchall():
    r = find_adherent(i[2])
    if r == False:
        erreurs.append(i[1]+' '+i[2])
    else:
        print """UPDATE profil SET email='%s', disi='%s' WHERE adherent_id=%s ;""" % (r[0], r[1], str(int(i[0])))
        c.execute("""UPDATE profil SET email='%s', disi='%s' WHERE adherent_id=%s ;""" % (r[0], r[1], str(int(i[0]))))
        db.commit()


print '\n\n'
for i in erreurs:
    print i

c.close()
