object FrameBattle: TFrameBattle
  Left = 0
  Top = 0
  Width = 902
  Height = 598
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object Panel1: TPanel
    Left = 0
    Top = 160
    Width = 902
    Height = 438
    Align = alClient
    TabOrder = 0
    object BattleLog: TRichEdit
      Left = 1
      Top = 1
      Width = 900
      Height = 436
      Align = alClient
      ScrollBars = ssVertical
      TabOrder = 0
      Zoom = 100
    end
  end
  object Panel2: TPanel
    Left = 0
    Top = 0
    Width = 902
    Height = 160
    Align = alTop
    BevelOuter = bvNone
    Caption = 'VS'
    TabOrder = 1
    object ttEnemyDamage: TLabel
      Left = 144
      Top = 103
      Width = 121
      Height = 21
      Caption = 'Damage: 1-2'
    end
    object ttEnemyLife: TLabel
      Left = 144
      Top = 79
      Width = 121
      Height = 21
      Caption = 'Life: 10/10'
    end
    object ttEnemyName: TLabel
      Left = 144
      Top = 34
      Width = 44
      Height = 22
      Caption = 'Name'
      Font.Charset = RUSSIAN_CHARSET
      Font.Color = clWindowText
      Font.Height = -19
      Font.Name = 'Courier New'
      Font.Style = [fsBold]
      ParentFont = False
    end
    object Image2: TImage
      Left = 11
      Top = 34
      Width = 118
      Height = 110
      Stretch = True
    end
    object ttEnemyLevel: TLabel
      Left = 144
      Top = 57
      Width = 88
      Height = 21
      Caption = 'Level: 1'
    end
    object ttEnemyArmor: TLabel
      Left = 144
      Top = 127
      Width = 88
      Height = 21
      Caption = 'Armor: 0'
    end
    object Panel3: TPanel
      Left = 565
      Top = 0
      Width = 337
      Height = 160
      Align = alRight
      BevelOuter = bvNone
      TabOrder = 0
      DesignSize = (
        337
        160)
      object Image1: TImage
        Left = 199
        Top = 34
        Width = 118
        Height = 110
        Anchors = [akTop, akRight]
        Stretch = True
      end
      object Label4: TLabel
        Left = 126
        Top = 33
        Width = 55
        Height = 22
        Alignment = taRightJustify
        Anchors = [akTop, akRight]
        Caption = #1043#1077#1088#1086#1081
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -19
        Font.Name = 'Courier New'
        Font.Style = [fsBold]
        ParentFont = False
      end
      object Label5: TLabel
        Left = 20
        Top = 78
        Width = 165
        Height = 21
        Alignment = taRightJustify
        Anchors = [akTop, akRight]
        Caption = #1047#1076#1086#1088#1086#1074#1100#1077': 10/10'
      end
      object ttCharDamage: TLabel
        Left = 86
        Top = 102
        Width = 99
        Height = 21
        Alignment = taRightJustify
        Anchors = [akTop, akRight]
        Caption = #1059#1088#1086#1085': 1-2'
      end
      object Label7: TLabel
        Left = 75
        Top = 56
        Width = 110
        Height = 21
        Alignment = taRightJustify
        Anchors = [akTop, akRight]
        Caption = #1059#1088#1086#1074#1077#1085#1100': 1'
      end
      object ttCharArmor: TLabel
        Left = 97
        Top = 126
        Width = 88
        Height = 21
        Alignment = taRightJustify
        Anchors = [akTop, akRight]
        Caption = #1041#1088#1086#1085#1103': 0'
      end
      object CharHPPanel: TPanel
        Tag = 5
        Left = 39
        Top = 10
        Width = 278
        Height = 15
        Margins.Right = 30
        Alignment = taRightJustify
        Anchors = [akTop, akRight, akBottom]
        BevelOuter = bvNone
        BorderStyle = bsSingle
        ParentBackground = False
        TabOrder = 0
        object Panel5: TPanel
          Tag = 5
          Left = -4
          Top = 0
          Width = 278
          Height = 11
          Margins.Right = 50
          Align = alRight
          Alignment = taLeftJustify
          BevelOuter = bvNone
          Color = clRed
          ParentBackground = False
          TabOrder = 0
        end
      end
    end
    object EnemyHPPanel: TPanel
      Tag = 5
      Left = 11
      Top = 10
      Width = 278
      Height = 15
      Alignment = taLeftJustify
      BevelOuter = bvNone
      BorderStyle = bsSingle
      ParentBackground = False
      TabOrder = 1
      object ttEnemyLifeBar: TPanel
        Tag = 5
        Left = 0
        Top = 0
        Width = 278
        Height = 11
        Align = alLeft
        Alignment = taLeftJustify
        BevelOuter = bvNone
        Color = clRed
        ParentBackground = False
        TabOrder = 0
      end
    end
  end
end
